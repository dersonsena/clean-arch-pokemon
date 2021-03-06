<?php

declare(strict_types=1);

namespace App\Market\Infra\Http;

use App\Market\UseCases\Purchase\InputBoundary;
use App\Market\UseCases\Purchase\Purchase;
use App\Shared\Adapters\Http\PayloadAction;

class PurchaseAction extends PayloadAction
{
    private Purchase $useCase;

    public function __construct(Purchase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $input = InputBoundary::build($this->body);

        return $this->useCase
            ->handle($input)
            ->toArray()['player'];
    }
}
