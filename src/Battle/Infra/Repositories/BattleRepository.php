<?php

declare(strict_types=1);

namespace App\Battle\Infra\Repositories;

use App\Battle\Domain\Battle;
use App\Battle\Domain\Factory\BattleFactory;
use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Domain\ValueObjects\BattleStatus;
use App\Battle\UseCases\Contracts\BattleRepository as BattleRepositoryRepository;

class BattleRepository implements BattleRepositoryRepository
{
    public function start(BattlePokemon $trainer1, BattlePokemon $trainer2): Battle
    {
        return BattleFactory::create([
            'id' => 200,
            'trainer1' => $trainer1,
            'trainer2' => $trainer2,
            'status' => BattleStatus::STARTED
        ]);
    }
}