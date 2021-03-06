<?php

declare(strict_types=1);

namespace App\Market\UseCases\CreateItem;

use App\Shared\Helpers\DTO;

final class InputBoundary extends DTO
{
    protected string $name;
    protected float $price;
    protected string $category;
    protected bool $isSalable = true;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return bool
     */
    public function isSalable(): bool
    {
        return $this->isSalable;
    }
}
