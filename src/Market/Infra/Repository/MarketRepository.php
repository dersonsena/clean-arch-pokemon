<?php

declare(strict_types=1);

namespace App\Market\Infra\Repository;

use App\Market\Domain\Cart;
use App\Market\Domain\Factory\ItemFactory;
use App\Market\Domain\Item;
use App\Market\Application\UseCases\Contracts\MarketRepository as MarketRepositoryInterface;
use App\Market\Domain\ValueObjects\Category;

class MarketRepository implements MarketRepositoryInterface
{
    public function purchase(Cart $cart): bool
    {
        return true;
    }

    public function getItem(int $id): ?Item
    {
        return ItemFactory::create([
            'id' => 5,
            'name' => 'Great Ball',
            'category' => Category::POKEBALL,
            'price' => 600,
            'quantity' => 5,
            'is_poke_ball' => true
        ]);
    }
}