<?php

declare(strict_types=1);

namespace App\Player\Domain\Exceptions;

use DomainException;
use Throwable;

class PokemonLimitExceededException extends DomainException
{
    public function __construct($message = "Limite de Pokemons atingido", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}