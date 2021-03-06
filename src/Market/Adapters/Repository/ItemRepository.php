<?php

declare(strict_types=1);

namespace App\Market\Adapters\Repository;

use App\Market\Domain\Item;
use App\Market\UseCases\Contracts\ItemRepository as ItemRepositoryInterface;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use DateTimeImmutable;

final class ItemRepository implements ItemRepositoryInterface
{
    private InsertStatement $insertStatement;

    public function __construct(InsertStatement $insertStatement)
    {
        $this->insertStatement = $insertStatement;
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
}
