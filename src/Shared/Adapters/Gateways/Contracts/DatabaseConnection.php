<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Gateways\Contracts;

use PDOStatement;

interface DatabaseConnection
{
    public function select(array $params = []): self;
    public function insert(array $values): bool;
    public function batchInsert(array $columns, array $values): bool;
    public function update(array $values, array $conditions = []): bool;
    public function delete(array $conditions): bool;
    public function orderBy(string $order): self;
    public function execute(string $query = null, array $binds = []): bool;
    public function fetchOne(): ?array;
    public function fetchAll(): array;
    public function lastInsertId(): int;
    public function setTable(string $tableName): self;
    public function beginTransaction(): bool;
    public function commit(): bool;
    public function rollback();
    public function getStatement(): PDOStatement;
}