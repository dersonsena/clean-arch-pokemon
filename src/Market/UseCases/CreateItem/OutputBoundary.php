<?php

declare(strict_types=1);

namespace App\Market\UseCases\CreateItem;

use App\Shared\Helpers\DTO;

final class OutputBoundary extends DTO
{
    protected int $id;
    protected string $name;
    protected float $price;
    protected string $category;
    protected string $createdAt;
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
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isSalable(): bool
    {
        return $this->isSalable;
    }
}
