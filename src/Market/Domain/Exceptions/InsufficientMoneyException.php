<?php

declare(strict_types=1);

namespace App\Market\Domain\Exceptions;

use App\Shared\Exceptions\AppException;

class InsufficientMoneyException extends AppException
{
    protected string $errorMessage = 'Jogador não tem dinheiro suficiente para esta compra';
}