<?php

namespace App\Market\Infra\Exceptions;

use Exception;
use Throwable;

class DbException extends Exception
{
    private array $details;

    public function __construct($message, $details = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->details = $details;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function __toString(): string
    {
        return parent::__toString() . PHP_EOL
            . 'Additional Information:' . PHP_EOL . print_r($this->details, true);
    }
}