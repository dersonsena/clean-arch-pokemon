<?php

declare(strict_types=1);

namespace App\Shared\Application\Enum;

final class ValidationErrorEnum extends Enum
{
    public const REQUIRED = 'required';
    public const EMPTY = 'empty';
    public const MIN_LENGTH = 'min-length';
    public const NOT_INTEGER = 'not-integer';
    public const NOT_FLOAT = 'not-float';
}