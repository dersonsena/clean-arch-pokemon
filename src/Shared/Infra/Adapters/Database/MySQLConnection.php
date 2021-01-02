<?php

namespace App\Shared\Infra\Adapters\Database;

use App\Shared\Contracts\DatabaseConnection;
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
        $conditions = $params['conditions'];

        $data = $this->params($conditions);

        if ($data) {
            $this->rawQuery .= ' WHERE ' . $data;
        }

        $this->query = $this->pdo->prepare($this->rawQuery);
        $this->bind($conditions);

        return $this;
    }

    public function insert(array $values): self
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

        return $this;
    }

    public function update(array $values, array $conditions = []): self
    {
        $this->rawQuery = 'UPDATE %s SET %s';
        $dataToUpdate = $this->params($values);

        $this->rawQuery = sprintf($this->rawQuery, $this->table, $dataToUpdate);

        if (!empty($conditions)) {
            $bindParams = $this->params($conditions);
            $this->rawQuery .= ' WHERE ' . $bindParams;
        }

        $this->query = $this->pdo->prepare($this->rawQuery);
        $this->bind($values);

        return $this;
    }

    public function delete(array $conditions): self
    {
        $this->rawQuery = "DELETE FROM `{$this->table}`";
        $this->rawQuery .= ' WHERE ' . $this->params($conditions);

        $this->query = $this->pdo->prepare($this->rawQuery);

        $this->bind($conditions);

        return $this;
    }

    public function execute(string $query = null): self
    {
        if (!is_null($query) && !empty($query)) {
            $this->query = $this->pdo->prepare($query);
        }

        $this->query->execute();

        return $this;
    }

    public function fetchOne()
    {
        $this->query->execute();
        return $this->query->fetch();
    }

    public function fetchAll(): array
    {
        $this->query->execute();
        return $this->query->fetchAll();
    }

    private function params(array $conditions): string
    {
        $fields = [];
        foreach ($conditions as $field => $value) {
            $fields[] = $field. '=:' . $field;
        }

        return implode(', ', $fields);
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
}