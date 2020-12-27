<?php

declare(strict_types=1);

namespace App\Market\Domain\Exceptions;

use DomainException;
use Throwable;

class MarketItemNotFoundException extends DomainException
{
    public function __construct($message = "Item do Mercado não foi encontrado", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}