<?php

declare(strict_types=1);

namespace App\Battle\Infra\Repositories;

use App\Battle\Domain\Contracts\StartBattleRepository as StartBattleRepositoryInterface;
use App\Player\Domain\Player;
use App\Pokemon\Domain\Pokemon;

class StartBattleRepository implements StartBattleRepositoryInterface
{
    public function start(Player $player, Pokemon $playerPokemon, Pokemon $challengerPokemon): bool
    {
        return true;
    }
}