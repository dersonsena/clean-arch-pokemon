<?php

declare(strict_types=1);

namespace App\Market\Domain\Factory;

use App\Market\Domain\Cart;
use App\Player\Domain\Factory\PlayerFactory;
use DateTimeImmutable;

final class CartFactory
{
    public static function create(array $values = []): Cart
    {
        $cart = new Cart();
        $cart->setCreatedAt(new DateTimeImmutable());

        if (empty($values)) {
            return $cart;
        }

        if (isset($values['player'])) {
            $values['player'] = PlayerFactory::create($values['player']);
        }

        $cart->fill($values);

        return $cart;
    }
}