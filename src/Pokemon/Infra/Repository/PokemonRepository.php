<?php

declare(strict_types=1);

namespace App\Pokemon\Infra\Repository;

use App\Pokemon\Domain\Factory\PokemonFactory;
use App\Pokemon\Domain\Pokemon;
use App\Pokemon\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Shared\Contracts\HttpClient;
use GuzzleHttp\Exception\ClientException;

class PokemonRepository implements PokemonRepositoryInterface
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function get(int $id): ?Pokemon
    {
        try {
            $response = $this->httpClient->get("https://pokeapi.co/api/v2/pokemon/{$id}");
            $data = json_decode($response->getBody()->getContents());

            return PokemonFactory::create([
                'id' => $data->id,
                'name' => ucfirst($data->name),
                'number' => $data->order,
                'height' => $data->height,
                'weight' => $data->weight,
                'image' => !empty($data->sprites->front_default) ? $data->sprites->front_default : null,
                'type' => [
                    'name' => ucfirst($data->types[0]->type->name)
                ],
                'level' => rand(10, 50)
            ]);
        } catch (ClientException $e) {
            return null;
        }
    }
}