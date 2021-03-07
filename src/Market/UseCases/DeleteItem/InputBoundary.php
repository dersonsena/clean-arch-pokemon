<?php

declare(strict_types=1);

namespace App\Market\UseCases\DeleteItem;

use App\Shared\Helpers\DTO;

final class InputBoundary extends DTO
{
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
