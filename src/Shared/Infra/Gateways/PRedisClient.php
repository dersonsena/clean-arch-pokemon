<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways;

use App\Shared\Infra\Gateways\Contracts\CacheSystem;
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
        if (!CACHE_ENABLE) {
            return false;
        }

        return (bool)$this->predisClient->exists($key);
    }

    public function getKey(string $key): ?string
    {
        if (!CACHE_ENABLE) {
            return null;
        }

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
