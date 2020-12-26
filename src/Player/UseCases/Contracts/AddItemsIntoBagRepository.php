<?php

declare(strict_types=1);

namespace App\Player\UseCases\Contracts;

use App\Player\Domain\BagItem;
use App\Player\Domain\Player;

interface AddItemsIntoBagRepository
{
    /**
     * @param Player $player
     * @param BagItem[] $items
     * @return bool
     */
    public function add(Player $player, array $items): bool;
}