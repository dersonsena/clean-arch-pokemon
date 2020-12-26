<?php

declare(strict_types=1);

namespace App\Battle\UseCases\Contracts;

use App\Player\Domain\Player;
use App\Pokemon\Domain\Pokemon;

interface StartBattleRepository
{
    /**
     * @param Player $player
     * @param Pokemon $playerPokemon
     * @param Pokemon $challengerPokemon
     * @return bool
     */
    public function start(Player $player, Pokemon $playerPokemon, Pokemon $challengerPokemon): bool;
}