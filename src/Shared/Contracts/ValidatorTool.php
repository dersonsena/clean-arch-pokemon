<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

interface ValidatorTool
{
    public const IS_NULL = 'is_null';
    public const STR_LENGTH = 'str_length';

    /**
     * @param mixed $value
     * @param string|callable $rule
     * @param array $options
     * @return bool
     */
    public function validate($value, $rule, array $options = []): bool;
}