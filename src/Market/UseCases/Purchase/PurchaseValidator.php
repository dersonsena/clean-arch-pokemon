<?php

declare(strict_types=1);

namespace App\Market\UseCases\Purchase;

use App\Shared\Application\ValidationErrorEnum;
use App\Shared\Infra\Gateways\Contracts\ValidatorTool;

final class PurchaseValidator
{
    private ValidatorTool $v;

    public function __construct(ValidatorTool $validatorTool)
    {
        $this->v = $validatorTool;
    }

    public function validate(InputBoundary $input): array
    {
        $errors = [];

        if (is_null($input->getPlayerId()) || empty($input->getPlayerId())) {
            $errors['player_id'] = ValidationErrorEnum::REQUIRED;
        }

        foreach ($input->getItems() as $i => $item) {
            if (!array_key_exists('id', $item)) {
                $errors[$i]['item_id'] = ValidationErrorEnum::REQUIRED;
            }

            if (!$this->v->validate($item['id'], ValidatorTool::IS_INT)) {
                $errors[$i]['item_id'] = ValidationErrorEnum::NOT_INTEGER;
            }

            if (!array_key_exists('price', $item)) {
                $errors[$i]['item_price'] = ValidationErrorEnum::REQUIRED;
            }

            if (!$this->v->validate($item['price'], ValidatorTool::IS_FLOAT)) {
                $errors[$i]['item_price'] = ValidationErrorEnum::NOT_FLOAT;
            }

            if (!array_key_exists('quantity', $item)) {
                $errors[$i]['item_quantity'] = ValidationErrorEnum::REQUIRED;
            }

            if (!$this->v->validate($item['quantity'], ValidatorTool::IS_INT)) {
                $errors[$i]['item_quantity'] = ValidationErrorEnum::NOT_INTEGER;;
            }

            if (!array_key_exists('total', $item)) {
                $errors[$i]['item_total'] = ValidationErrorEnum::REQUIRED;
            }

            if (!$this->v->validate($item['total'], ValidatorTool::IS_FLOAT)) {
                $errors[$i]['item_total'] = ValidationErrorEnum::NOT_FLOAT;
            }
        }

        return $errors;
    }
}
