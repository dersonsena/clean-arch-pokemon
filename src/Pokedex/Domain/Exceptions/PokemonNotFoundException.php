<?php

declare(strict_types=1);

namespace App\Pokedex\Domain\Exceptions;

use App\Shared\Contracts\AppExceptionBase;
use App\Shared\Exceptions\AppValidationException;

class PokemonNotFoundException extends AppValidationException
{
    protected string $type = AppExceptionBase::TYPE_INVALID_INPUT;
    protected string $errorMessage = 'Pokémon não encontrado';
}