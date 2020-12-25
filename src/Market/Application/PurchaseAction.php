<?php

declare(strict_types=1);

namespace App\Market\Application;

use App\Market\UseCases\Purchase\Purchase;
use App\Shared\Application\ActionBase;

class PurchaseAction extends ActionBase
{
    private Purchase $useCase;

    public function __construct(Purchase $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        return ['ola' => 'mundo'];
    }
}