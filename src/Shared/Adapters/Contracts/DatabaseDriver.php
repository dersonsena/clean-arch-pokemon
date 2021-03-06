<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Contracts;

use App\Shared\Adapters\Contracts\QueryBuilder\QueryStatement;

interface DatabaseDriver
{
    public function close();
    public function setQueryStatement(QueryStatement $queryStatement): DatabaseDriver;
    public function execute(): DatabaseDriver;
    public function executeSql(string $sql, array $values = []): DatabaseDriver;
    public function lastInsertedId(): int;
    public function fetchOne(): ?array;
    public function fetchAll(): array;
    public function beginTransaction(): bool;
    public function commit(): bool;
    public function rollback();
}
