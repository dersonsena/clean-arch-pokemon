<?php

declare(strict_types=1);

namespace App\Market\UseCases\Contracts;

use App\Market\Domain\Item;

interface ItemRepository
{
    public function getById(int $id): ?Item;
    public function insert(Item $item): Item;
    public function update(Item $item): Item;
    public function delete(Item $item): Item;
}
