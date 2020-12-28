<?php

declare(strict_types=1);

namespace App\Pokemon\Infra\Repository;

use App\Pokemon\Domain\Factory\PokemonFactory;
use App\Pokemon\Domain\Pokemon;
use App\Pokemon\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Shared\Contracts\CacheSystem;
use App\Shared\Contracts\PokemonAPI;
use GuzzleHttp\Exception\ClientException;

class PokemonRepository implements PokemonRepositoryInterface
{
    private CacheSystem $cache;
    private PokemonAPI $pokemonAPI;

    public function __construct(
        PokemonAPI $pokemonAPI,
        CacheSystem $cache
    ) {
        $this->cache = $cache;
        $this->pokemonAPI = $pokemonAPI;
    }

    public function get(int $id): ?Pokemon
    {
        $cacheKey = $this->cache->getParams()['prefixes']['pokemon'] . $id;

        if ($this->cache->hasKey($cacheKey)) {
            $pokemon = json_decode($this->cache->getKey($cacheKey), true);
            return PokemonFactory::create($pokemon);
        }

        try {
            $data = $this->pokemonAPI->getPokemonById($id);

            $pokemon = [
                'id' => $data['id'],
                'name' => ucfirst($data['name']),
                'number' => $data['order'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'image' => !empty($data['sprites']['front_default']) ? $data['sprites']['front_default'] : null,
                'type' => [
                    'name' => ucfirst($data['types'][0]['type']['name'])
                ],
                'level' => rand(10, 50)
            ];

            $this->cache->setKey($cacheKey, json_encode($pokemon));

            return PokemonFactory::create($pokemon);
        } catch (ClientException $e) {
            return null;
        }
    }
}