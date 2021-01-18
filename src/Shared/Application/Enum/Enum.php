<?php

declare(strict_types=1);

namespace App\Shared\Application\Enum;

use ReflectionClass;

abstract class Enum
{
    private function __construct()
    {}

    public static function items(): array
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getConstants();
    }
}