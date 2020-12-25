<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Contracts\DebitMoneyRepository as DebitMoneyRepositoryInterface;

class DebitMoneyRepository implements DebitMoneyRepositoryInterface
{
    public function debit(float $money): bool
    {
        return true;
    }
}