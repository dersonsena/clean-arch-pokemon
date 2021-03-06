<?php

declare(strict_types=1);

namespace App\Market\UseCases\Purchase;

use App\Shared\Helpers\DTO;

final class InputBoundary extends DTO
{
    protected int $playerId;
    protected array $items;

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
