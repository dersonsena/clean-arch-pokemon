<?php

declare(strict_types=1);

namespace App\Player\Domain;

use App\Market\Domain\Item;
use App\Shared\Domain\Entity;

final class Bag extends Entity
{
    protected Player $player;

    /**
     * @var Item[]
     */
    protected array $items = [];

    /**
     * @var Item[]
     */
    protected array $pokeballs = [];

    public function addItem(Item $item)
    {
        if ($item->isPokeBall()) {
            $this->pokeballs[] = $item;
            return;
        }

        $this->items[] = $item;
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
     * @return Bag
     */
    public function setPlayer(Player $player): Bag
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}