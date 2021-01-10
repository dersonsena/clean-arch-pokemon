<?php

declare(strict_types=1);

namespace App\Player\Domain\Exceptions;

use App\Shared\Contracts\AppExceptionBase;
use App\Shared\Exceptions\AppValidationException;

class PlayerNotFoundException extends AppValidationException
{
    protected string $type = AppExceptionBase::TYPE_INVALID_INPUT;
    protected string $errorMessage = 'Jogador não encontrado';
}