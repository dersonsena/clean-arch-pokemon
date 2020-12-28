<?php

declare(strict_types=1);

namespace App\Shared\Infra\Adapters;

use App\Shared\Contracts\CacheSystem;
use Predis\Client;

class PRedisClient implements CacheSystem
{
    private Client $predisClient;
    private array $params;

    public function __construct(Client $predisClient, array $params)
    {
        $this->predisClient = $predisClient;
        $this->params = $params;
    }

    public function hasKey(string $key): bool
    {
        return (bool)$this->predisClient->exists($key);
    }

    public function getKey(string $key): ?string
    {
        return $this->predisClient->get($key);
    }

    public function setKey(string $key, string $value): void
    {
        $this->predisClient->set($key, $value);
    }

    public function getParams(): array
    {
        return $this->params;
    }
}