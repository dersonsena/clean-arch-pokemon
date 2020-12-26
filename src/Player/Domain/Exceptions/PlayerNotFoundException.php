<?php

declare(strict_types=1);

namespace App\Player\Domain\Exceptions;

use Exception;
use Throwable;

class PlayerNotFoundException extends Exception
{
    public function __construct($message = 'Jogador não encontrado', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}