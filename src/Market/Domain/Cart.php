<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Entity;

final class Cart extends Entity
{
    protected float $total;
    protected int $count;

    /**
     * @var Item[]
     */
    protected array $items;

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }
}