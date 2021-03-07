<?php

declare(strict_types=1);

namespace App\Market\Adapters\Http;

use App\Market\UseCases\DeleteItem\DeleteItem;
use App\Market\UseCases\DeleteItem\InputBoundary;
use App\Shared\Adapters\Http\PayloadAction;

final class DeleteItemAction extends PayloadAction
{
    private DeleteItem $useCase;

    public function __construct(DeleteItem $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $input = InputBoundary::build(['id' => (int)$this->args['id']]);

        return $this->useCase
            ->handle($input)
            ->toArray();
    }
}
