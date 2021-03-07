<?php

declare(strict_types=1);

namespace App\Market\Adapters\Http;

use App\Market\UseCases\UpdateItem\InputBoundary;
use App\Market\UseCases\UpdateItem\UpdateItem;
use App\Shared\Adapters\Http\PayloadAction;

final class UpdateItemAction extends PayloadAction
{
    private UpdateItem $useCase;

    public function __construct(UpdateItem $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $input = InputBoundary::build(array_merge(
            $this->body,
            ['id' => (int)$this->args['id']]
        ));

        return $this->useCase
            ->handle($input)
            ->toArray();
    }
}
