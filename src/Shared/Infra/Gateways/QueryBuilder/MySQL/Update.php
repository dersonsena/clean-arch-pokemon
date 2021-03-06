<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways\QueryBuilder\MySQL;

use App\Shared\Infra\Gateways\Contracts\DatabaseDriver;
use App\Shared\Infra\Gateways\Contracts\QueryBuilder\UpdateStatement;

final class Update implements UpdateStatement
{
    private string $tableName;
    private array $values = [];
    private array $conditions = [];
    private DatabaseDriver $connection;

    public function __construct(DatabaseDriver $connection)
    {
        $this->connection = $connection;
    }

    public function table(string $tableName): UpdateStatement
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function values(array $values): UpdateStatement
    {
        $this->values = $values;
        return $this;
    }

    public function conditions(array $conditions): UpdateStatement
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function update()
    {
        $this->connection
            ->setQueryStatement($this)
            ->execute();

        $this->tableName = '';
        $this->values = [];
        $this->conditions = [];
    }

    public function getValues(): array
    {
        return array_merge(
            array_values($this->values),
            array_values($this->conditions)
        );
    }

    public function __toString(): string
    {
        $sql = sprintf('UPDATE `%s`', $this->tableName);
        $columns = array_keys($this->values);
        $columnsQuery = [];

        foreach ($columns as $column) {
            $columnsQuery[] = $column . ' = ?';
        }

        $sql .= ' SET ' . implode(', ', $columnsQuery);

        if (!empty($this->conditions)) {
            $i = 0;

            foreach ($this->conditions as $column => $value) {
                $clause = ($i === 0 ? 'WHERE' : 'AND');
                $sql .= sprintf(" %s %s = %s", $clause, $column, '?');
                $i++;
            }
        }

        return $sql;
    }
}
