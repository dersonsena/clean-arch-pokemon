<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use App\Shared\Contracts\AppExceptionBase;

class AppValidationException extends AppException
{
    protected string $type = AppExceptionBase::TYPE_INVALID_INPUT;
    protected string $errorMessage = 'Erro de Validação na Aplicação';
}