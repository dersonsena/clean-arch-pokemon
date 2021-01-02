<?php

declare(strict_types=1);

namespace App\Market\Domain\Exceptions;

use DomainException;
use Throwable;

class MartItemNotFoundException extends DomainException
{
    public function __construct($id, $message = "Item da loja com ID %s não foi encontrado", $code = 0, Throwable $previous = null)
    {
        $message = sprintf($message, $id);
        parent::__construct($message, $code, $previous);
    }
}