<?php

declare(strict_types=1);

namespace App\Market\Adapters\Http;

use App\Market\UseCases\Contracts\ItemRepository;
use App\Shared\Adapters\Http\PayloadAction;

final class GetItemAction extends PayloadAction
{
    private ItemRepository $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function handle(): array
    {
        $item = $this->repository->getById((int)$this->args['id']);

        if (is_null($item)) {
            return [];
        }

        return $item->toArray();
    }
}
