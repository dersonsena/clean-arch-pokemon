<?php

declare(strict_types=1);

namespace App\Market\Domain\Exceptions;

use App\Shared\Exceptions\AppException;

class CreatePurchaseException extends AppException
{
    protected string $errorMessage = 'Não foi possível fazer a compra.';
}