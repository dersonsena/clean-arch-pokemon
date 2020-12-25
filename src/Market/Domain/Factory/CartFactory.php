<?php

declare(strict_types=1);

namespace App\Market\Domain\Factory;

use App\Market\Domain\Cart;

final class CartFactory
{
    public static function create(array $values = []): Cart
    {
        $cart = new Cart();

        if (empty($values)) {
            return $cart;
        }

        $cart->fill($values);

        return $cart;
    }
}