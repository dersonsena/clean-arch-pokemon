<?php

declare(strict_types=1);

namespace App\Market\Domain\Factory;

use App\Market\Domain\Item;
use App\Market\Domain\ValueObjects\Category;

final class ItemFactory
{
    public static function create(array $values = []): Item
    {
        $item = new Item();

        if (empty($values)) {
            return $item;
        }

        if (isset($values['category'])) {
            $values['category'] = new Category($values['category']);
        }

        $item->fill($values);

        return $item;
    }
}