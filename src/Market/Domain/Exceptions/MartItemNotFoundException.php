<?php

declare(strict_types=1);

namespace App\Market\Domain\Exceptions;

use App\Shared\Exceptions\AppValidationException;

class MartItemNotFoundException extends AppValidationException
{
    protected string $errorMessage = 'Item do Mercado não foi encontrado';
}