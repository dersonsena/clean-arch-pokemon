<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways\Contracts\QueryBuilder;

interface SelectStatement extends QueryStatement
{
    public function select(array $columns = []): SelectStatement;
    public function from(string $table): SelectStatement;
    public function where(string $field, $value, string $operator = '='): SelectStatement;
    public function andWhere(string $field, $value, string $operator = '='): SelectStatement;
    public function orWhere(string $field, $value, string $operator = '='): SelectStatement;
    public function whereLike(string $field, $value): SelectStatement;
    public function orWhereLike(string $field, $value): SelectStatement;
    public function groupBy(array $columns): SelectStatement;
    public function orderBy(array $columns): SelectStatement;
    public function limit(int $limit, int $offset = 0): SelectStatement;
    public function fetchOne(): ?array;
    public function fetchAll(): array;
}
