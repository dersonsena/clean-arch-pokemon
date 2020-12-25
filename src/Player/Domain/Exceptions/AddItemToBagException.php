<?php

declare(strict_types=1);

namespace App\Player\Domain\Exceptions;

use Exception;
use Throwable;

class AddItemToBagException extends Exception
{
    public function __construct($message = "Erro ao adicionar item na Mochila", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}