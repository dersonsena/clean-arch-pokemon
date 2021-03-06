<?php

declare(strict_types=1);

namespace App\Pokedex\UseCases\Contracts;

use App\Player\Domain\Player;
use App\Pokedex\Domain\Pokedex;
use App\Pokedex\Domain\Pokemon;

interface PokedexRepository
{
    public function getPlayerPokedex(Player $player): ?Pokedex;
    public function markPokemonAsSeen(Player $player, Pokemon $pokemon);
    public function markPokemonAsCaptured(Player $player, Pokemon $pokemon);
}
