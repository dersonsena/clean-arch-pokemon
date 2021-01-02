<?php

declare(strict_types=1);

namespace App\Market\Domain\Exceptions;

use DomainException;
use Throwable;

class InvalidItemCategoryException extends DomainException
{
    public function __construct(string $name, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Categoria de Item '{$name}' é inválido", $code, $previous);
    }
}