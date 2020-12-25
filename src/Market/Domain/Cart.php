<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Entity;

final class Cart extends Entity
{
    protected float $total = 0;
    protected int $count = 0;

    /**
     * @var array
     */
    protected array $items;

    public function addItem(Item $item): void
    {
        $this->items[] = $item;

        $this->total += $item->getPrice();
        $this->count++;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}