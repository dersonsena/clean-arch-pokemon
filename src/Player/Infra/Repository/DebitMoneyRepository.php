<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Contracts\DebitMoneyRepository as DebitMoneyRepositoryInterface;
use App\Player\Domain\Player;

class DebitMoneyRepository implements DebitMoneyRepositoryInterface
{
    public function debit(Player $player, float $money): bool
    {
        $player->debitMoney($money);
        return true;
    }
}