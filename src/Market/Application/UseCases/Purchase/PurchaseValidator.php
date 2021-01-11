<?php

declare(strict_types=1);

namespace App\Market\Application\UseCases\Purchase;

use App\Shared\Contracts\ValidatorTool;

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
            $errors['player_id'] = 'required';
        }

        foreach ($input->getItems() as $i => $item) {
            if (!array_key_exists('id', $item)) {
                $errors[$i]['item_id'] = 'required';
            }

            if (!$this->v->validate($item['id'], ValidatorTool::IS_INT)) {
                $errors[$i]['item_id'] = 'not-integer';
            }

            if (!array_key_exists('price', $item)) {
                $errors[$i]['item_price'] = 'required';
            }

            if (!$this->v->validate($item['price'], ValidatorTool::IS_FLOAT)) {
                $errors[$i]['item_price'] = 'not-float';
            }

            if (!array_key_exists('quantity', $item)) {
                $errors[$i]['item_quantity'] = 'required';
            }

            if (!$this->v->validate($item['quantity'], ValidatorTool::IS_INT)) {
                $errors[$i]['item_quantity'] = 'not-integer';
            }

            if (!array_key_exists('total', $item)) {
                $errors[$i]['item_total'] = 'required';
            }

            if (!$this->v->validate($item['total'], ValidatorTool::IS_FLOAT)) {
                $errors[$i]['item_total'] = 'not-float';
            }
        }

        return $errors;
    }
}