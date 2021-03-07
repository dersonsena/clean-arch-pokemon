<?php

declare(strict_types=1);

namespace App\Market\Adapters\Repository;

use App\Market\Domain\Factory\ItemFactory;
use App\Market\Domain\Item;
use App\Market\UseCases\Contracts\ItemRepository as ItemRepositoryInterface;
use App\Shared\Adapters\Contracts\QueryBuilder\DeleteStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\UpdateStatement;
use App\Shared\Exceptions\AppValidationException;
use DateTimeImmutable;

final class ItemRepository implements ItemRepositoryInterface
{
    private InsertStatement $insertStatement;
    private UpdateStatement $updateStatement;
    private SelectStatement $selectStatement;
    private DeleteStatement $deleteStatement;

    public function __construct(
        InsertStatement $insertStatement,
        UpdateStatement $updateStatement,
        SelectStatement $selectStatement,
        DeleteStatement $deleteStatement
    ) {
        $this->insertStatement = $insertStatement;
        $this->updateStatement = $updateStatement;
        $this->selectStatement = $selectStatement;
        $this->deleteStatement = $deleteStatement;
    }

    public function getById(int $id): ?Item
    {
        $record = $this->selectStatement
            ->select()
            ->from('mart_items')
            ->where('id', $id)
            ->fetchOne();

        if (is_null($record)) {
            return null;
        }

        return ItemFactory::create($record);
    }

    public function insert(Item $item): Item
    {
        $now = new DateTimeImmutable();
        $values = $item->toArray(true);
        $values['created_at'] = $now->format('Y-m-d H:i:s');

        $itemId = $this->insertStatement
            ->into('mart_items')
            ->values($values)
            ->insert();

        $item->setId($itemId);
        $item->setCreatedAt($now);

        return $item;
    }

    public function update(Item $item): Item
    {
        $recordItem = $this->getById($item->getId());

        if (is_null($recordItem)) {
            throw new AppValidationException(['id' => 'not-found'], 'Market item not found.');
        }

        $values = array_map(function ($value) {
            if (is_bool($value)) {
                return $value === true ? 1 : 0;
            }

            return $value;
        }, $item->toArray(true));

        $this->updateStatement
            ->table('mart_items')
            ->values($values)
            ->conditions(['id' => $item->getId()])
            ->update();

        return ItemFactory::create(array_merge(
            $recordItem->toArray(true),
            $item->toArray(true)
        ));
    }

    public function delete(Item $item): Item
    {
        $recordItem = $this->getById($item->getId());

        if (is_null($recordItem)) {
            throw new AppValidationException(['id' => 'not-found'], 'Market item not found.');
        }

        $this->deleteStatement
            ->table('mart_items')
            ->conditions(['id' => $item->getId()])
            ->delete();

        return $recordItem;
    }
}
