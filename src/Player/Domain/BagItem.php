<?php

declare(strict_types=1);

namespace App\Player\Domain;

use App\Shared\Domain\Entity;

final class BagItem extends Entity
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
     * @return BagItem
     */
    public function setName(string $name): BagItem
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
     * @return BagItem
     */
    public function setPrice(float $price): BagItem
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
     * @return BagItem
     */
    public function setIsPokeBall(bool $isPokeBall): BagItem
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
     * @return BagItem
     */
    public function setIsSalable(bool $isSalable): BagItem
    {
        $this->isSalable = $isSalable;
        return $this;
    }
}