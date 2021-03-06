<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways;

use App\Shared\Infra\Gateways\Contracts\HttpClient;
use App\Shared\Infra\Gateways\Contracts\PokemonAPI;
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

    public function getPokemonByAlias(string $alias): ?array
    {
        try {
            $response = $this->httpClient->get($this->baseUrl . "/pokemon/{$alias}");
            return json_decode($response->getBody()->getContents(), true);

        } catch (ClientException $e) {
            return null;
        }
    }
}
