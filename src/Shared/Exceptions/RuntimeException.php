<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use App\Shared\Contracts\AppExceptionBase;

class RuntimeException extends AppException
{
    protected string $type = AppExceptionBase::TYPE_INTERNAL_ERROR;
    protected string $errorMessage = 'Ocorreu um erro inesperado';
}