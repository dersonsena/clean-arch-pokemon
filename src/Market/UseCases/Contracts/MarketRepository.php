<?php

declare(strict_types=1);

namespace App\Market\UseCases\Contracts;

use App\Market\Domain\Cart;
use App\Market\Domain\Item;
use App\Player\Domain\Player;

interface MarketRepository
{
    public function purchase(Cart $cart, Player $player): bool;
    public function getMartItem(int $id): ?Item;
    public function getMarketItems(array $conditions = []): array;
}
