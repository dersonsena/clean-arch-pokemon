<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Gateways\Contracts\QueryBuilder;

interface InsertStatement extends QueryStatement
{
    public function into(string $tableName): InsertStatement;
    public function values(array $values): InsertStatement;
    public function insert(): int;
    public function batchInsert();
}
