<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\Contracts;

use App\Battle\Domain\Battle;
use App\Battle\Domain\ValueObjects\BattlePokemon;

interface BattleRepository
{
    public function start(BattlePokemon $trainer1, BattlePokemon $trainer2): Battle;
}