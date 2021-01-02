<?php

declare(strict_types=1);

namespace App\Market\Application\UseCases\Contracts;

use App\Market\Domain\Cart;
use App\Market\Domain\Item;

interface MarketRepository
{
    public function purchase(Cart $cart): bool;
    public function getMartItem(int $id): ?Item;
}