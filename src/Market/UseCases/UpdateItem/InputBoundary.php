<?php

declare(strict_types=1);

namespace App\Market\UseCases\UpdateItem;

use App\Shared\Helpers\DTO;

final class InputBoundary extends DTO
{
    protected int $id;
    protected string $name;
    protected float $price;
    protected string $category;
    protected bool $isSalable = true;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

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
    public function getIsSalable(): bool
    {
        return $this->isSalable;
    }
}
