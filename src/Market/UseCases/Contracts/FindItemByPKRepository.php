<?php

declare(strict_types=1);

namespace App\Market\UseCases\Contracts;

use App\Market\Domain\Item;

interface FindItemByPKRepository
{
    /**
     * @param int $id
     * @return Item|null
     */
    public function getItem(int $id): ?Item;
}