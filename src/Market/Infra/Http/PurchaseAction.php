<?php

declare(strict_types=1);

namespace App\Market\Infra\Http;

use App\Market\Application\UseCases\Purchase\InputBoundary;
use App\Market\Application\UseCases\Purchase\Purchase;
use App\Shared\Infra\Http\ActionBase;

class PurchaseAction extends ActionBase
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