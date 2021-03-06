<?php

declare(strict_types=1);

namespace App\Shared\Adapters\QueryBuilder\MySQL;

use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use Exception;

final class Select implements SelectStatement
{
    private array $select;
    private string $from;
    private array $conditions = [];
    private array $groupBy = [];
    private array $orderBy = [];
    private array $limit = [];
    private array $values = [];
    private DatabaseDriver $connection;

    public function __construct(DatabaseDriver $connection)
    {
        $this->connection = $connection;
    }

    public function fetchAll(): array
    {
        $rows = $this->connection
            ->setQueryStatement($this)
            ->execute()
            ->fetchAll();

        $this->conditions = [];
        $this->values = [];

        return $rows;
    }

    public function fetchOne(): ?array
    {
        $row = $this->connection
            ->setQueryStatement($this)
            ->execute()
            ->fetchOne();

        $this->conditions = [];
        $this->values = [];

        return $row;
    }

    public function select(array $columns = []): self
    {
        $this->select = (!empty($columns) ? $columns : ['*']);
        return $this;
    }

    public function from(string $table): self
    {
        if (empty($table)) {
            throw new Exception('You must inform table name.');
        }

        $this->from = $table;

        return $this;
    }

    public function where(string $field, $value, string $operator = '='): self
    {
        if (empty($this->conditions)) {
            $this->addCondition('WHERE', $field, $value, $operator);
            return $this;
        }

        $this->andWhere($field, $value, $operator);
        return $this;
    }

    public function andWhere(string $field, $value, string $operator = '='): self
    {
        $this->addCondition('AND', $field, $value, $operator);
        return $this;
    }

    public function orWhere(string $field, $value, string $operator = '='): self
    {
        $this->addCondition('OR', $field, $value, $operator);
        return $this;
    }

    public function whereLike(string $field, $value): self
    {
        $this->addCondition('AND', $field, $value, 'LIKE');
        return $this;
    }

    public function orWhereLike(string $field, $value): self
    {
        $this->addCondition('OR', $field, $value, 'LIKE');
        return $this;
    }

    public function groupBy(array $columns): self
    {
        $this->groupBy = $columns;
        return $this;
    }

    public function orderBy(array $columns): self
    {
        $this->orderBy = $columns;
        return $this;
    }

    public function limit(int $limit, int $offset = 0): self
    {
        $this->limit = [$limit, $offset];
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function __toString(): string
    {
        $columns = '`' . implode('`, `', $this->select) . '`';

        if (count($this->select) === 1 && $this->select[0] === '*') {
            $columns = '*';
        }

        $sql = sprintf("SELECT %s FROM `%s`", $columns, $this->from);

        foreach ($this->conditions as $condition) {
            [$statement, $field, $value, $operator] = $condition;

            $sql .= sprintf(" %s `%s` %s %s", $statement, $field, $operator, '?');
            $this->values[] = $value;
        }

        if (!empty($this->groupBy)) {
            $sql .= sprintf(' GROUP BY %s', implode(', ', $this->groupBy));
        }

        if (!empty($this->orderBy)) {
            $sql .= sprintf(' ORDER BY %s', implode(', ', $this->orderBy));
        }

        if (!empty($this->limit)) {
            [$limit, $offset] = $this->limit;

            $limitSql = sprintf(" LIMIT %s", $limit);

            if (!empty($offset)) {
                $limitSql = sprintf(" LIMIT %s OFFSET %s", $limit, $offset);
            }

            $sql .= $limitSql;
        }

        return $sql;
    }

    private function addCondition(string $statement, string $field, $value, string $operator = '='): void
    {
        $this->conditions[] = [$statement, $field, $value, $operator];
    }
}
