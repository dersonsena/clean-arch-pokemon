<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Gateways\Contracts\QueryBuilder;

interface QueryStatement
{
    public function getValues(): array;
    public function __toString(): string;
}
