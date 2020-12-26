<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\UseCases\Contracts\AddItemsIntoBagRepository as AddItemsIntoBagRepositoryInterface;
use App\Player\Domain\Player;

class AddItemsIntoBagRepository implements AddItemsIntoBagRepositoryInterface
{
    public function add(Player $player, array $items): bool
    {
        return true;
    }
}