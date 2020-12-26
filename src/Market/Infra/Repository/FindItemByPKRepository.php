<?php

declare(strict_types=1);

namespace App\Market\Infra\Repository;

use App\Market\Domain\Contracts\FindItemByPKRepository as FindItemByPKRepositoryInterface;
use App\Market\Domain\Factory\ItemFactory;
use App\Market\Domain\Item;

class FindItemByPKRepository implements FindItemByPKRepositoryInterface
{
    public function get(int $id): ?Item
    {
        return ItemFactory::create([
            'id' => 5,
            'name' => 'Great Ball',
            'price' => 600,
            'quantity' => 5,
            'is_poke_ball' => true
        ]);
    }
}