<?php

namespace App\Shared\Adapters\Gateways\Drivers;

use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\QueryStatement;
use PDO;
use PDOStatement;
use App\Shared\Adapters\Gateways\Contracts\DatabaseDriver;

class MySQLDriver implements DatabaseDriver
{
    private ?PDO $pdo;
    private PDOStatement $statement;
    private QueryStatement $queryStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function close()
    {
        $this->pdo = null;
    }

    public function setQueryStatement(QueryStatement $queryStatement): DatabaseDriver
    {
        $this->queryStatement = $queryStatement;
        return $this;
    }

    public function execute(): bool
    {
        $this->statement = $this->pdo->prepare((string)$this->queryStatement);
        return $this->statement->execute($this->queryStatement->getValues());
    }

    public function lastInsertedId(): int
    {
        return $this->pdo->lastInsertId();
    }

    public function fetchOne():? array
    {
        $this->execute();
        return $this->statement->fetch();
    }

    public function fetchAll(): array
    {
        $this->execute();
        return $this->statement->fetchAll();
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollback(): bool
    {
        return $this->pdo->rollback();
    }

    public function batchInsert(array $columns, array $values): bool
    {
        $columnCount = count($columns);
        $columnList = '('. implode(', ', $columns) .')';
        $rowPlaceholder = ' (' .implode(', ', array_fill(1, $columnCount, '?')) .')';

        $this->rawQuery = sprintf(
            'INSERT INTO %s%s VALUES %s',
            $this->table,
            $columnList,
            implode(', ', array_fill(1, count($values), $rowPlaceholder))
        );

        $this->query = $this->pdo->prepare($this->rawQuery);

        $data = [];

        foreach ($values as $rowData) {
            $data = array_merge($data, array_values($rowData));
        }

        return $this->query->execute($data);
    }
}
