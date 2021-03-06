<?php

declare(strict_types=1);

namespace App\Pokemon\Infra\Repository;

use App\Pokemon\Domain\Exceptions\PokemonNotFoundException;
use App\Pokemon\Domain\Factory\PokemonFactory;
use App\Pokemon\Domain\Factory\TypeFactory;
use App\Pokemon\Domain\Pokemon;
use App\Pokemon\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Pokemon\UseCases\Contracts\TypeRepository;
use App\Shared\Infra\Gateways\Contracts\CacheSystem;
use App\Shared\Infra\Gateways\Contracts\DatabaseDriver;
use App\Shared\Infra\Gateways\Contracts\PokemonAPI;
use GuzzleHttp\Exception\ClientException;

class PokemonRepository implements PokemonRepositoryInterface
{
    private string $tableName = 'pokemons';
    private CacheSystem $cache;
    private PokemonAPI $pokemonAPI;
    private DatabaseDriver $connection;
    private TypeRepository $typeRepository;

    public function __construct(
        PokemonAPI $pokemonAPI,
        CacheSystem $cache,
        DatabaseDriver $connection,
        TypeRepository $typeRepository
    ) {
        $this->cache = $cache;
        $this->pokemonAPI = $pokemonAPI;
        $this->connection = $connection;
        $this->typeRepository = $typeRepository;
    }

    public function get(int $pk): ?Pokemon
    {
        $row = $this->connection
            ->setTable($this->tableName)
            ->select(['conditions' => ['id' => $pk]])
            ->fetchOne();

        if (!$row) {
            return null;
        }

        $row['id'] = (int)$row['id'];

        return PokemonFactory::create($row);
    }

    public function getByAlias(string $alias): ?Pokemon
    {
        $cacheKey = $this->cache->getParams()['prefixes']['pokemon'] . $alias;

        if ($this->cache->hasKey($cacheKey)) {
            $pokemon = json_decode($this->cache->getKey($cacheKey), true);
            return PokemonFactory::create($pokemon);
        }

        try {
            $row = $this->connection
                ->setTable($this->tableName)
                ->select(['conditions' => ['alias' => $alias]])
                ->fetchOne();

            if ($row) {
                $pokemon = PokemonFactory::create($row);
                $pokemon->setType($this->typeRepository->get((int)$row['type_id']));
                $this->cache->setKey($cacheKey, json_encode($pokemon->toArray()));

                return $pokemon;
            }

            $response = $this->pokemonAPI->getPokemonByAlias($alias);

            if (!$response) {
                throw new PokemonNotFoundException(['pokemon_alias' => 'invalid']);
            }

            $typeName = trim($response['types'][0]['type']['name']);

            $pokemonType = $this->typeRepository->findTypeByName($typeName);

            if (!$pokemonType) {
                $pokemonType = $this->typeRepository->createType(TypeFactory::create(['name' => $typeName]));
            }

            $data = [
                'api_id' => $response['id'],
                'name' => ucfirst($response['name']),
                'alias' => $response['name'],
                'number' => $response['order'],
                'height' => $response['height'],
                'weight' => $response['weight'],
                'image' => !empty($response['sprites']['front_default']) ? $response['sprites']['front_default'] : null,
                'type_id' => $pokemonType->getId(),
                'level' => rand(10, 50)
            ];

            $this->connection->setTable($this->tableName)->insert($data);

            unset($data['type_id']);

            $data['id'] = $this->connection->lastInsertId();

            $pokemon = PokemonFactory::create($data);
            $pokemon->setType($pokemonType);

            $this->cache->setKey($cacheKey, json_encode($pokemon->toArray()));

            return $pokemon;
        } catch (ClientException $e) {
            return null;
        }
    }
}
