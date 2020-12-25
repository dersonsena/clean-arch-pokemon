<?php

declare(strict_types=1);

namespace App\Pokedex\Domain;

use App\Pokemon\Domain\Pokemon;
use App\Shared\Domain\Entity;

final class Item extends Entity
{
    protected Pokemon $pokemon;
    protected bool $isCaptured = false;

    /**
     * @return Pokemon
     */
    public function getPokemon(): Pokemon
    {
        return $this->pokemon;
    }

    /**
     * @param Pokemon $pokemon
     * @return Item
     */
    public function setPokemon(Pokemon $pokemon): Item
    {
        $this->pokemon = $pokemon;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCaptured(): bool
    {
        return $this->isCaptured;
    }

    /**
     * @param bool $isCaptured
     * @return Item
     */
    public function setIsCaptured(bool $isCaptured): Item
    {
        $this->isCaptured = $isCaptured;
        return $this;
    }
}