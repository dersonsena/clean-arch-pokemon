<?php

declare(strict_types=1);

namespace App\Shared\Infra\Gateways;

use App\Shared\Infra\Gateways\Contracts\ValidatorTool;
use App\Shared\Exceptions\RuntimeException;
use Respect\Validation\Validator;

class RespectValidation implements ValidatorTool
{
    private array $mapRules = [
        ValidatorTool::IS_NULL => 'nullType',
        ValidatorTool::STR_LENGTH => 'length',
        ValidatorTool::IS_INT => 'intType',
        ValidatorTool::IS_FLOAT => 'floatType',
        ValidatorTool::DECIMAL => 'decimal'
    ];

    public function validate($value, $rule, array $options = []): bool
    {
        if (!isset($this->mapRules[$rule])) {
            throw new RuntimeException([], "Regra de validação '{$rule}' é inválida.");
        }

        $ruleName = $this->mapRules[$rule];

        if (is_callable($ruleName)) {
            return (boolean)$rule($value, $options);
        }

        $respectRule = $this->getRespectValidator($ruleName, $options);
        return $respectRule->validate($value);
    }

    private function getRespectValidator(string $ruleName, array $options = []): Validator
    {
        if ($ruleName === 'length') {
            $min = $options['min'] ?? null;
            $max = $options['max'] ?? null;

            return Validator::{$ruleName}($min, $max);
        }

        if ($ruleName === 'decimal') {
            $decimals = $options['decimals'] ?? 2;
            return Validator::{$ruleName}($decimals);
        }

        return Validator::{$ruleName}();
    }
}
