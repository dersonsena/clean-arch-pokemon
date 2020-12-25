<?php

declare(strict_types=1);

namespace App\Bag\Domain;

use App\Shared\Domain\Entity;

final class Item extends Entity
{
    protected string $name;
    protected float $price;
    protected bool $isPokeBall = false;
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
     * @return bool
     */
    public function isPokeBall(): bool
    {
        return $this->isPokeBall;
    }

    /**
     * @param bool $isPokeBall
     * @return Item
     */
    public function setIsPokeBall(bool $isPokeBall): Item
    {
        $this->isPokeBall = $isPokeBall;
        return $this;
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