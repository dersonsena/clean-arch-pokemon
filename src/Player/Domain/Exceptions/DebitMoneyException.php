<?php

namespace App\Player\Domain\Exceptions;

use Exception;
use Throwable;

class DebitMoneyException extends Exception
{
    public function __construct(float $value, $message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ?? sprintf("Houve um erro ao debitar %.2f", $value);

        parent::__construct($message, $code, $previous);
    }
}