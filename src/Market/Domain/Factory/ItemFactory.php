<?php

declare(strict_types=1);

namespace App\Market\Domain\Factory;

use App\Market\Domain\Item;

final class ItemFactory
{
    public static function create(array $values = []): Item
    {
        $item = new Item();

        if (empty($values)) {
            return $item;
        }

        $item->fill($values);

        return $item;
    }
}