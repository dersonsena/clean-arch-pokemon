<?php

declare(strict_types=1);

namespace App\Pokemon\Domain\Exceptions;

use Exception;
use Throwable;

class PokemonNotFoundException extends Exception
{
    public function __construct($message = "Pokémon não encontrado", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}