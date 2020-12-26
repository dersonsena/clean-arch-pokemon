<?php

declare(strict_types=1);

namespace App\Battle\UseCases\Contracts;

use App\Battle\Domain\Battle;
use App\Battle\Domain\ValueObjects\BattlePokemon;

interface StartBattleRepository
{
    /**
     * @param BattlePokemon $trainer1
     * @param BattlePokemon $trainer2
     * @return Battle
     */
    public function start(BattlePokemon $trainer1, BattlePokemon $trainer2): Battle;
}