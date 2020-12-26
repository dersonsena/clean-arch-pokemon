<?php

declare(strict_types=1);

namespace App\Market\UseCases\Contracts;

use App\Market\Domain\Cart;

interface CreatePurchaseRepository
{
    public function purchase(Cart $cart): bool;
}