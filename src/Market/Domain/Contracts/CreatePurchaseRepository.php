<?php

declare(strict_types=1);

namespace App\Market\Domain\Contracts;

use App\Market\Domain\Cart;

interface CreatePurchaseRepository
{
    public function create(Cart $cart): bool;
}