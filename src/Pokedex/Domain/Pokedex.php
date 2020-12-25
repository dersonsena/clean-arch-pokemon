<?php

declare(strict_types=1);

namespace App\Pokedex\Domain;

use App\Shared\Domain\Entity;

final class Pokedex extends Entity
{
    /**
     * @var Item[]
     */
    protected array $items;

    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }
}