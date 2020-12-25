<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use InvalidArgumentException;
use Throwable;

class InvalidGenderException extends InvalidArgumentException
{
    public function __construct($message = "Gênero Inválido", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}