<?php

declare(strict_types=1);

namespace App\Market\Application\UseCases\Purchase;

use App\Shared\Helpers\DTO;

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