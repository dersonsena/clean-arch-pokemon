<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Gateways\Contracts\QueryBuilder;

interface UpdateStatement extends QueryStatement
{
    public function table(string $tableName): UpdateStatement;
    public function values(array $values): UpdateStatement;
    public function conditions(array $conditions): UpdateStatement;
    public function update(): bool;
}
