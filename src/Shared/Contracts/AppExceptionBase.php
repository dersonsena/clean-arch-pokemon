<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

interface AppExceptionBase
{
    public const TYPE_INTERNAL_ERROR = 'INTERNAL_ERROR';
    public const TYPE_INVALID_INTEGRATION = 'INVALID_INTEGRATION';
    public const TYPE_INVALID_INPUT = 'INVALID_INPUT';

    public function getDetails(): array;
}