<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Market\Domain\ValueObjects\Category;
use App\Shared\Domain\Entity;

final class Item extends Entity
{
    protected string $name;
    protected float $price;
    protected Category $category;
    protected bool $isSalable = true;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Item
     */
    public function setPrice(float $price): Item
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param Category $category
     * @return Item
     */
    public function setCategory(Category $category): Item
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return bool
     */
    public function isPokeBall(): bool
    {
        return $this->category->value() === Category::POKEBALL;
    }

    /**
     * @return bool
     */
    public function isSalable(): bool
    {
        return $this->isSalable;
    }

    /**
     * @param bool $isSalable
     * @return Item
     */
    public function setIsSalable(bool $isSalable): Item
    {
        $this->isSalable = $isSalable;
        return $this;
    }
}