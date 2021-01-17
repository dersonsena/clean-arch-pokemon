<?php

declare(strict_types=1);

namespace App\Shared\Application\Enum;

use ReflectionClass;

abstract class Enum
{
    public static function items(): array
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getConstants();
    }
}