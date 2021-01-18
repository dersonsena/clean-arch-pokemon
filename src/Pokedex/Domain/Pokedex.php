<?php

declare(strict_types=1);

namespace App\Pokedex\Domain;

use App\Player\Domain\Player;
use App\Shared\Domain\Entity;

final class Pokedex extends Entity
{
    protected Player $player;

    /**
     * @var Pokemon[]
     */
    protected array $pokemons;

    public function addPokemon(Pokemon $pokemon)
    {
        $this->pokemons[] = $pokemon;
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
     * @return Pokedex
     */
    public function setPlayer(Player $player): Pokedex
    {
        $this->player = $player;
        return $this;
    }

    public function count(): int
    {
        return $this->countCaptured() + $this->countViewed();
    }

    public function countCaptured(): int
    {
        return 10;
    }

    public function countViewed(): int
    {
        return 20;
    }
}