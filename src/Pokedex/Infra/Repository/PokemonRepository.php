<?php

declare(strict_types=1);

namespace App\Pokedex\Infra\Repository;

use App\Pokedex\Domain\Exceptions\PokemonNotFoundException;
use App\Pokedex\Domain\Factory\PokemonFactory;
use App\Pokedex\Domain\Factory\TypeFactory;
use App\Pokedex\Domain\Pokemon;
use App\Pokedex\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Pokedex\UseCases\Contracts\TypeRepository;
use App\Shared\Infra\Gateways\Contracts\CacheSystem;
use App\Shared\Infra\Gateways\Contracts\DatabaseDriver;
use App\Shared\Infra\Gateways\Contracts\PokemonAPI;
use App\Shared\Infra\Gateways\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Infra\Gateways\Contracts\QueryBuilder\SelectStatement;
use GuzzleHttp\Exception\ClientException;

class PokemonRepository implements PokemonRepositoryInterface
{
    private CacheSystem $cache;
    private PokemonAPI $pokemonAPI;
    private DatabaseDriver $connection;
    private TypeRepository $typeRepository;
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;

    public function __construct(
        PokemonAPI $pokemonAPI,
        CacheSystem $cache,
        DatabaseDriver $connection,
        TypeRepository $typeRepository,
        SelectStatement $selectStatement,
        InsertStatement $insertStatement
    ) {
        $this->cache = $cache;
        $this->pokemonAPI = $pokemonAPI;
        $this->connection = $connection;
        $this->typeRepository = $typeRepository;
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
    }

    public function get(int $pk): ?Pokemon
    {
        $row = $this->selectStatement
            ->select()
            ->from('pokemons')
            ->where('id', $pk)
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
            $row = $this->selectStatement
                ->select()
                ->from('pokemons')
                ->where('alias', $alias)
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

            $lastInsertedId = $this->insertStatement
                ->into('pokemons')
                ->values($data)
                ->insert();

            unset($data['type_id']);

            $data['id'] = $lastInsertedId;

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

        $rows = $this->connection
            ->executeSql($sql, $binds)
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
