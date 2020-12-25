<?php

declare(strict_types=1);

namespace App\Market\UseCases\Purchase;

use App\Market\Domain\Item;
use App\Shared\UseCases\DTO;

final class InputBoundary extends DTO
{
    /**
     * @var array
     */
    protected array $items;

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}