<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways\Contracts;

interface CacheSystem
{
    public function hasKey(string $key): bool;
    public function getKey(string $key): ?string;
    public function setKey(string $key, string $value): void;
    public function getParams(): array;
}
