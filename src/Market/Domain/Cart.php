<?php

declare(strict_types=1);

namespace App\Market\Domain;

use App\Player\Domain\Player;
use App\Shared\Domain\Entity;
use DateTimeInterface;

final class Cart extends Entity
{
    protected Player $player;
    protected float $total = 0;
    protected int $count = 0;
    protected DateTimeInterface $createdAt;

    /**
     * @var CartItem[]
     */
    protected array $items;

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;

        $this->total += $item->getPrice() * $item->getQuantity();
        $this->count += $item->getQuantity();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return float|int
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return Cart
     */
    public function setPlayer(Player $player): Cart
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return Cart
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Cart
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getMartItemsList(): array
    {
        return array_map(fn($item) => $item->getItem(), $this->getItems());
    }
}