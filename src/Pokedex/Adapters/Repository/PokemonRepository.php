<?php

declare(strict_types=1);

namespace App\Pokedex\Adapters\Repository;

use App\Pokedex\Domain\Exceptions\PokemonNotFoundException;
use App\Pokedex\Domain\Factory\PokemonFactory;
use App\Pokedex\Domain\Factory\TypeFactory;
use App\Pokedex\Domain\Pokemon;
use App\Pokedex\Application\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Pokedex\Application\UseCases\Contracts\TypeRepository;
use App\Shared\Adapters\Gateways\Contracts\CacheSystem;
use App\Shared\Adapters\Gateways\Contracts\DatabaseDriver;
use App\Shared\Adapters\Gateways\Contracts\PokemonAPI;
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

    public function search(array $params): array
    {
        $data = [];
        $binds = [];

        $sql = "
            SELECT `p`.*, `t`.`id` AS `type_id`, `t`.`name` AS `type_name` 
            FROM `pokemons` AS `p`
            INNER JOIN `pokemon_types` AS `t` ON `t`.`id` = `p`.`type_id`
            WHERE 1=1
        ";

        if (isset($params['id'])) {
            $sql .= ' AND `p`.`id` = :id';
            $binds['id'] = $params['id'];
        }

        if (isset($params['name'])) {
            $sql .= ' AND `p`.`name` LIKE :name';
            $binds['name'] = "%{$params['name']}%";
        }

        if (isset($params['alias'])) {
            $sql .= ' AND `p`.`alias` = :alias';
            $binds['alias'] = $params['alias'];
        }

        if (isset($params['number'])) {
            $sql .= ' AND `p`.`number` = :number';
            $binds['number'] = $params['number'];
        }

        $this->connection->execute($sql, $binds);

        $rows = $this->connection
            ->getStatement()
            ->fetchAll();

        foreach ($rows as $row) {
            $row['type'] = [
                'id' => (int)$row['type_id'],
                'name' => $row['type_name']
            ];

            $data[] = PokemonFactory::create($row);
        }

        return $data;
    }
}