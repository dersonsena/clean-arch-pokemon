<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways\Contracts;

interface ValidatorTool
{
    public const IS_NULL = 'is_null';
    public const STR_LENGTH = 'str_length';
    public const IS_INT = 'is_int';
    public const IS_FLOAT = 'is_float';
    public const DECIMAL = 'decimal';

    /**
     * @param mixed $value
     * @param string|callable $rule
     * @param array $options
     * @return bool
     */
    public function validate($value, $rule, array $options = []): bool;
}
