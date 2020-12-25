<?php

declare(strict_types=1);

namespace App\Market\UseCases\Purchase;

use App\Shared\UseCases\DTO;

final class OutputBoundary extends DTO
{
    protected int $count;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}