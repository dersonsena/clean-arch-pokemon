<?php

declare(strict_types=1);

namespace App\Pokedex\Domain\Factory;

use App\Pokedex\Domain\Type;

final class TypeFactory
{
    public static function create(array $values = []): Type
    {
        $type = new Type();

        if (empty($values)) {
            return $type;
        }

        $type->fill($values);

        return $type;
    }
}