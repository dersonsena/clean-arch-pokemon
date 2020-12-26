<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Entity;

final class Cart extends Entity
{
    protected float $total = 0;
    protected int $count = 0;

    /**
     * @var Item[]
     */
    protected array $items;

    public function addItem(Item $item): void
    {
        $this->items[] = $item;

        $this->total += $item->getPrice() * $item->getQuantity();
        $this->count += $item->getQuantity();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return float|int
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}