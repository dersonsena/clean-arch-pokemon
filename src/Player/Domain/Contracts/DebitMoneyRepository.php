<?php

declare(strict_types=1);

namespace App\Player\Domain\Contracts;

interface DebitMoneyRepository
{
    /**
     * @param float $money
     * @return bool
     */
    public function debit(float $money): bool;
}