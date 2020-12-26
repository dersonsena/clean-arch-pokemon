<?php

declare(strict_types=1);

namespace App\Pokemon\Domain\Factory;

use App\Pokemon\Domain\Type;

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