<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Shared\Domain\Entity;

final class CartItem extends Entity
{
    protected Item $item;
    protected string $name;
    protected float $price;
    protected int $quantity;
    protected float $total;

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     * @return CartItem
     */
    public function setItem(Item $item): CartItem
    {
        $this->item = $item;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CartItem
     */
    public function setName(string $name): CartItem
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
     * @return CartItem
     */
    public function setPrice(float $price): CartItem
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return CartItem
     */
    public function setQuantity(int $quantity): CartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return CartItem
     */
    public function setTotal(float $total): CartItem
    {
        $this->total = $total;
        return $this;
    }
}