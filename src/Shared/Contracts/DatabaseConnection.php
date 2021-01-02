<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

interface DatabaseConnection
{
    public function select(array $params = []): self;
    public function insert(array $values): self;
    public function update(array $values, array $conditions = []): self;
    public function delete(array $conditions): self;
    public function execute(string $query = null): self;
    public function fetchOne();
    public function fetchAll(): array;
    public function lastInsertId(): int;
    public function setTable(string $tableName): self;
}