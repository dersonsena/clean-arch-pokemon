<?php

declare(strict_types=1);

namespace App\Shared\Exceptions;

use App\Shared\Contracts\AppExceptionBase;
use Exception;
use Throwable;

abstract class AppException extends Exception implements AppExceptionBase
{
    protected array $details;
    protected string $type = AppExceptionBase::TYPE_INTERNAL_ERROR;
    protected string $errorMessage = 'Server Error';

    public function __construct(array $details, $message = "", ?int $code = 0, Throwable $previous = null)
    {
        $this->details = $details;
        $message = (!empty($message) ? $message : $this->errorMessage);

        parent::__construct($message, $code, $previous);
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}