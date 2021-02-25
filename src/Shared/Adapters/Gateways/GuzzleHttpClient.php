<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Gateways;

use App\Shared\Adapters\Gateways\Contracts\HttpClient;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface as Response;

class GuzzleHttpClient implements HttpClient
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => '',
            'timeout' => 2
        ]);
    }

    public function get(string $uri, array $params = []): Response
    {
        return $this->httpClient->get($uri, [
            'query' => $params['query']
        ]);
    }

    public function post(string $uri, array $params = []): Response
    {
        return $this->httpClient->post($uri, [
            'body' => $params['body']
        ]);
    }
}