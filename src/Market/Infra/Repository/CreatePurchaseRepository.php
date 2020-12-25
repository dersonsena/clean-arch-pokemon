<?php

declare(strict_types=1);

namespace App\Market\Infra\Repository;

use App\Market\Domain\Cart;
use App\Market\Domain\Contracts\CreatePurchaseRepository as CreatePurchaseRepositoryInterface;

class CreatePurchaseRepository implements CreatePurchaseRepositoryInterface
{
    public function create(Cart $cart): bool
    {
        return true;
    }
}