<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Contracts\AddItemsIntoBagRepository as AddItemsIntoBagRepositoryInterface;
use App\Player\Domain\Player;

class AddItemsIntoBagRepository implements AddItemsIntoBagRepositoryInterface
{
    public function add(Player $player): bool
    {
        return true;
    }
}