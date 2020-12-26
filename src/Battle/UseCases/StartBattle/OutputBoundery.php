<?php

declare(strict_types=1);

namespace App\Battle\UseCases\StartBattle;

use App\Shared\UseCases\DTO;

final class OutputBoundery extends DTO
{
    protected array $battle;

    /**
     * @return array
     */
    public function getBattle(): array
    {
        return $this->battle;
    }
}