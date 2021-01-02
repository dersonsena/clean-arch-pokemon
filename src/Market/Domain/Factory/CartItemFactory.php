<?php

declare(strict_types=1);

namespace App\Market\Domain\Factory;

use App\Market\Domain\CartItem;

final class CartItemFactory
{
    public static function create(array $values = []): CartItem
    {
        $item = new CartItem();

        if (empty($values)) {
            return $item;
        }

        if (isset($values['item'])) {
            $values['item'] = ItemFactory::create($values['item']);
        }

        if (isset($values['price'])) {
            $values['price'] = (float)$values['price'];
        }

        if (isset($values['quantity'])) {
            $values['quantity'] = (int)$values['quantity'];
        }

        if (isset($values['total'])) {
            $values['total'] = (float)$values['total'];
        }

        $item->fill($values);

        return $item;
    }
}