<?php

declare(strict_types=1);

namespace App\Market\UseCases\CreateItem;

use App\Market\Domain\Factory\ItemFactory;
use App\Market\UseCases\Contracts\ItemRepository;

final class CreateItem
{
    private ItemRepository $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $item = ItemFactory::create($input->toArray());
        $item = $this->repository->insert($item);

        return OutputBoundary::build($item->toArray());
    }
}
