<?php

declare(strict_types=1);

namespace App\Battle\Domain\ValueObjects;

use App\Player\Domain\Player;
use App\Pokedex\Domain\Pokemon;
use JsonSerializable;

final class BattlePokemon implements JsonSerializable
{
    private Pokemon $pokemon;
    private ?Player $trainer;
    private bool $hasTrainer;

    public function __construct(Pokemon $pokemon, Player $trainer = null)
    {
        $this->pokemon = $pokemon;
        $this->trainer = $trainer;
        $this->hasTrainer = !is_null($trainer);
    }

    /**
     * @return Pokemon
     */
    public function getPokemon(): Pokemon
    {
        return $this->pokemon;
    }

    /**
     * @return Player|null
     */
    public function getTrainer(): ?Player
    {
        return $this->trainer;
    }

    /**
     * @return bool
     */
    public function hasTrainer(): bool
    {
        return $this->hasTrainer;
    }

    public function jsonSerialize(): array
    {
        return [
            'pokemon' => $this->pokemon,
            'trainer' => $this->trainer
        ];
    }
}