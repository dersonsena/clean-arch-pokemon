<?php

declare(strict_types=1);

namespace App\Player\Domain\Contracts;

use App\Player\Domain\Player;

interface AddItemsIntoBagRepository
{
    /**
     * @param Player $player
     * @return bool
     */
    public function add(Player $player): bool;
}