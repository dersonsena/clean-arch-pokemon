<?php

namespace App\Shared\Adapters\Gateways\Database;

use App\Shared\Adapters\Gateways\Contracts\DatabaseConnection;
use PDO;
use PDOStatement;

class MySQLConnection implements DatabaseConnection
{
    private PDO $pdo;
    private string $table;
    private PDOStatement $query;
    private string $rawQuery;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setTable(string $tableName): self
    {
        $this->table = $tableName;
        return $this;
    }

    public function select(array $params = []): self
    {
        $columns = $params['columns'] ?? '*';
        $this->rawQuery = "SELECT {$columns} FROM `{$this->table}`";
        $conditions = $params['conditions'] ?? [];

        $data = $this->params($conditions, 'AND');

        if ($data) {
            $this->rawQuery .= ' WHERE ' . $data;
        }

        $this->query = $this->pdo->prepare($this->rawQuery);
        $this->bind($conditions);

        return $this;
    }

    public function orderBy(string $order): self
    {
        $this->rawQuery = " ORDER BY {$order}";

        return $this;
    }

    public function insert(array $values): bool
    {
        $this->rawQuery = 'INSERT INTO %s (%s) VALUES (%s)';
        $originalFields = array_keys($values);
        $fieldsToBind = [];

        foreach ($originalFields as $fieldName) {
            $fields[] = $fieldName;
            $fieldsToBind[] = ':' . $fieldName;
        }

        $fields = implode(', ', $fields);
        $fieldsToBind = implode(', ', $fieldsToBind);
        $this->rawQuery = sprintf($this->rawQuery, $this->table, $fields, $fieldsToBind);

        $this->query = $this->pdo->prepare($this->rawQuery);
        $this->bind($values);

        return $this->execute();
    }

    public function update(array $values, array $conditions = []): bool
    {
        $this->rawQuery = 'UPDATE %s SET %s';
        $dataToUpdate = $this->params($values);

        $this->rawQuery = sprintf($this->rawQuery, $this->table, $dataToUpdate);

        if (!empty($conditions)) {
            $bindParams = $this->params($conditions);
            $this->rawQuery .= ' WHERE ' . $bindParams;
        }

        $this->query = $this->pdo->prepare($this->rawQuery);
        $this->bind($conditions);
        $this->bind($values);

        return $this->execute();
    }

    public function delete(array $conditions): bool
    {
        $this->rawQuery = "DELETE FROM `{$this->table}`";
        $this->rawQuery .= ' WHERE ' . $this->params($conditions);

        $this->query = $this->pdo->prepare($this->rawQuery);

        $this->bind($conditions);

        return $this->execute();
    }

    public function execute(string $query = null, array $binds = []): bool
    {
        if (!is_null($query) && !empty($query)) {
            $this->query = $this->pdo->prepare($query);
        }

        if (!empty($binds)) {
            return $this->query->execute($binds);
        }

        return $this->query->execute();
    }

    public function fetchOne(): ?array
    {
        $this->query->execute();
        $row = $this->query->fetch();
        return $row ? $row : null;
    }

    public function fetchAll(): array
    {
        $this->query->execute();
        return $this->query->fetchAll();
    }

    private function params(array $conditions, string $separator = ','): string
    {
        $fields = [];

        foreach ($conditions as $field => $value) {
            $fields[] = $field . ' = :' . $field;
        }

        return implode(" {$separator} ", $fields);
    }

    private function bind(array $data): void
    {
        foreach ($data as $field => $value) {
            $this->query->bindValue($field, $value);
        }
    }

    public function lastInsertId(): int
    {
        return $this->pdo->lastInsertId();
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

    public function getStatement(): PDOStatement
    {
        return $this->query;
    }
}