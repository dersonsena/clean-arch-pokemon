<?php

declare(strict_types=1);

namespace App\Shared\Adapters\QueryBuilder\Postgres;

use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;

final class Insert implements InsertStatement
{
    private string $tableName;
    private array $values;
    private DatabaseDriver $connection;
    private string $sql;

    public function __construct(DatabaseDriver $connection)
    {
        $this->connection = $connection;
    }

    public function into(string $tableName): InsertStatement
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function values(array $values): InsertStatement
    {
        $this->values = $values;
        return $this;
    }

    public function insert(): int
    {
        $this->sql = sprintf('INSERT INTO %s', $this->tableName);

        $columns = array_keys($this->values);
        $values = array_fill(0, count($this->values), '?');

        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        $this->sql .= sprintf(' (%s) VALUES (%s)', $columns, $values);

        $this->values = array_values($this->values);

        $this->connection
            ->setQueryStatement($this)
            ->execute();

        $this->tableName = '';
        $this->values = [];

        return $this->connection->lastInsertedId();
    }

    public function batchInsert()
    {
        $this->sql = sprintf('INSERT INTO %s', $this->tableName);

        $columns = array_keys($this->values[0]);
        $valuesSql = '';
        $batchValues = [];

        foreach ($this->values as $row) {
            $fill = array_fill(0, count($row), '?');
            $valuesSql .= sprintf('(%s), ', implode(', ', $fill));

            foreach ($row as $value) {
                $batchValues[] = $value;
            }
        }

        $this->values = $batchValues;

        $valuesSql = substr_replace($valuesSql, '', -2);
        $columns = implode(', ', $columns);

        $this->sql .= sprintf(' (%s) VALUES ', $columns) . $valuesSql;

        $this->connection
            ->setQueryStatement($this)
            ->execute();
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function __toString(): string
    {
        return $this->sql;
    }
}
