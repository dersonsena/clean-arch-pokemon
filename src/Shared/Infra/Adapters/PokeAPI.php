<?php

declare(strict_types=1);

namespace App\Shared\Infra\Adapters;

use App\Shared\Contracts\HttpClient;
use App\Shared\Contracts\PokemonAPI;
use GuzzleHttp\Exception\ClientException;

class PokeAPI implements PokemonAPI
{
    private string $baseUrl;
    private HttpClient $httpClient;
    private array $params;

    public function __construct(HttpClient $httpClient, array $params)
    {
        $this->baseUrl = $params['baseUrl'];
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    public function getPokemonById(int $id): ?array
    {
        try {
            $response = $this->httpClient->get($this->baseUrl . "/pokemon/{$id}");
            return json_decode($response->getBody()->getContents(), true);

        } catch (ClientException $e) {
            return null;
        }
    }
}