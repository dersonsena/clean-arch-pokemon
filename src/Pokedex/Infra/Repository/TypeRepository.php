<?php

declare(strict_types=1);

namespace App\Pokedex\Infra\Repository;

use App\Pokedex\Domain\Factory\TypeFactory;
use App\Pokedex\Domain\Type;
use App\Pokedex\UseCases\Contracts\TypeRepository as TypeRepositoryInterface;
use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;

class TypeRepository implements TypeRepositoryInterface
{
    private DatabaseDriver $connection;
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;

    public function __construct(
        DatabaseDriver $connection,
        SelectStatement $selectStatement,
        InsertStatement $insertStatement
    ) {
        $this->connection = $connection;
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
    }

    public function findTypeByName(string $name): ?Type
    {
        $row = $this->selectStatement
            ->select()
            ->from('pokemon_types')
            ->where('name', $name)
            ->fetchOne();

        if (!$row) {
            return null;
        }

        $row['id'] = (int)$row['id'];

        return TypeFactory::create($row);
    }

    public function createType(Type $type): Type
    {
        $lastInsertedId = $this->insertStatement
            ->into('pokemon_types')
            ->values($type->toArray())
            ->insert();

        $type->setId($lastInsertedId);

        return $type;
    }

    public function get(int $pk): ?Type
    {
        $row = $this->selectStatement
            ->select()
            ->from('pokemon_types')
            ->where('id', $pk)
            ->fetchOne();

        if (!$row) {
            return null;
        }

        $row['id'] = (int)$row['id'];

        return TypeFactory::create($row);
    }
}
