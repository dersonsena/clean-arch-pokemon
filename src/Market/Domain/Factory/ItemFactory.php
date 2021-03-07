<?php

declare(strict_types=1);

namespace App\Market\Domain\Factory;

use App\Market\Domain\Item;
use App\Market\Domain\ValueObjects\Category;
use DateTimeImmutable;

final class ItemFactory
{
    public static function create(array $values = []): Item
    {
        $item = new Item();

        if (empty($values)) {
            return $item;
        }

        if (isset($values['id'])) {
            $values['id'] = (int)$values['id'];
        }

        if (isset($values['price'])) {
            $values['price'] = (float)$values['price'];
        }

        if (isset($values['category'])) {
            $values['category'] = new Category($values['category']);
        }

        if (isset($values['is_salable'])) {
            $values['is_salable'] = (bool)$values['is_salable'];
        }

        if (isset($values['created_at']) && is_string($values['created_at'])) {
            $values['created_at'] = new DateTimeImmutable($values['created_at']);
        }

        $item->fill($values);

        return $item;
    }
}
