<?php

declare(strict_types=1);

namespace App\Bag\Domain;

use App\Pokemon\Domain\Pokemon;
use App\Shared\Domain\Entity;

final class Bag extends Entity
{
    /**
     * @var Item[]
     */
    protected array $items;

    /**
     * @var Item[]
     */
    protected array $pokeballs;

    /**
     * @var Pokemon[]
     */
    protected array $party;

    public function addItem(Item $item)
    {
        if ($item->isPokeBall()) {
            $this->pokeballs[] = $item;
            return;
        }

        $this->items[] = $item;
    }

    public function addPokemonToParty(Pokemon $pokemon)
    {
        $this->party[] = $pokemon;
    }
}