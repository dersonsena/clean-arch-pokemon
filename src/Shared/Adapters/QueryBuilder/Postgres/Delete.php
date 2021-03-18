<?php

declare(strict_types=1);

namespace App\Shared\Adapters\QueryBuilder\Postgres;

use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\DeleteStatement;

final class Delete implements DeleteStatement
{
    private string $tableName;
    private array $conditions = [];
    private DatabaseDriver $connection;

    public function __construct(DatabaseDriver $connection)
    {
        $this->connection = $connection;
    }

    public function table(string $tableName): DeleteStatement
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function conditions(array $conditions): DeleteStatement
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function delete()
    {
        $this->connection
            ->setQueryStatement($this)
            ->execute();

        $this->tableName = '';
        $this->conditions = [];
    }

    public function getValues(): array
    {
        return array_values($this->conditions);
    }

    public function __toString(): string
    {
        $sql = sprintf('DELETE FROM %s', $this->tableName);

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
