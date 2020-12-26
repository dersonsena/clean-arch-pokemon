<?php

declare(strict_types=1);

namespace App\Battle\UseCases;

use App\Shared\UseCases\DTO;

final class InputBoundery extends DTO
{
    protected int $playerId;

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }
}