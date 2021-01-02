<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\StartBattle;

use App\Shared\Helpers\DTO;

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