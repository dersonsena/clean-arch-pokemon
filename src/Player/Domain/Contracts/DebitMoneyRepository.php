<?php

declare(strict_types=1);

namespace App\Player\Domain\Contracts;

use App\Player\Domain\Player;

interface DebitMoneyRepository
{
    /**
     * @param Player $player
     * @param float $money
     * @return bool
     */
    public function debit(Player $player, float $money): bool;
}