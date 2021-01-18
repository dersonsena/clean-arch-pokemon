<?php

declare(strict_types=1);

namespace App\Pokedex\Domain\Exceptions;

use App\Shared\Contracts\AppExceptionBase;
use App\Shared\Exceptions\AppValidationException;

class PokedexNotFoundException extends AppValidationException
{
    protected string $type = AppExceptionBase::TYPE_INVALID_INPUT;
    protected string $errorMessage = 'Pokédex do jogador não foi encontrado';
}