<?php

declare(strict_types=1);

namespace App\Player\Domain\Factory;

use App\Player\Domain\BagItem;

final class BagItemFactory
{
    public static function create(array $values = []): BagItem
    {
        $item = new BagItem();

        if (empty($values)) {
            return $item;
        }

        $item->fill($values);

        return $item;
    }
}