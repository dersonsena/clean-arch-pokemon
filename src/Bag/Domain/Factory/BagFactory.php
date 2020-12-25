<?php

declare(strict_types=1);

namespace App\Bag\Domain\Factory;

use App\Bag\Domain\Bag;

final class BagFactory
{
    public static function create(array $values = []): Bag
    {
        $bag = new Bag();

        if (empty($values)) {
            return $bag;
        }

        $bag->fill($values);

        return $bag;
    }
}