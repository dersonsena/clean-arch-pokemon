<?php

declare(strict_types=1);

namespace App\Market\Adapters\Http;

use App\Market\UseCases\CreateItem\CreateItem;
use App\Market\UseCases\CreateItem\InputBoundary;
use App\Shared\Adapters\Http\PayloadAction;

final class CreateItemAction extends PayloadAction
{
    private CreateItem $useCase;

    public function __construct(CreateItem $useCase) {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $input = InputBoundary::build($this->body);

        return $this->useCase
            ->handle($input)
            ->toArray();
    }
}
