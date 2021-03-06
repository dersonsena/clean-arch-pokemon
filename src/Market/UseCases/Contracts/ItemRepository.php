<?php

declare(strict_types=1);

namespace App\Market\UseCases\Contracts;

use App\Market\Domain\Item;

interface ItemRepository
{
    public function insert(Item $item): Item;
}
