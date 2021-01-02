<?php

declare(strict_types=1);

namespace App\Player\Domain;

use App\Player\Domain\Exceptions\PokemonLimitExceededException;
use App\Pokemon\Domain\Pokemon;
use App\Shared\Domain\Entity;

final class Party extends Entity
{
    /**
     * @var Pokemon[]
     */
    protected array $pokemons = [];

    public function addPokemon(Pokemon $pokemon): void
    {
        if ($this->count() === 8) {
            throw new PokemonLimitExceededException();
        }

        $this->pokemons[] = $pokemon;
    }

    public function count(): int
    {
        return count($this->pokemons);
    }
}