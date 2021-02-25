<?php

declare(strict_types=1);

namespace App\Pokemon\Domain\Exceptions;

use App\Shared\Exceptions\AppExceptionBase;
use App\Shared\Exceptions\AppValidationException;
use Throwable;

class PokemonNotFoundException extends AppValidationException
{
    protected string $type = AppExceptionBase::TYPE_INVALID_INPUT;
    protected string $errorMessage = 'Pokémon não encontrado';
}