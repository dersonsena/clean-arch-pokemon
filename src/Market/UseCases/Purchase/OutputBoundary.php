<?php

declare(strict_types=1);

namespace App\Market\UseCases\Purchase;

use App\Shared\UseCases\DTO;

final class OutputBoundary extends DTO
{
    protected array $player;

    /**
     * @return array
     */
    public function getPlayer(): array
    {
        return $this->player;
    }
}