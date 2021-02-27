<?php

declare(strict_types=1);

namespace App\Battle\Adapters\Repositories;

use App\Battle\Domain\Battle;
use App\Battle\Domain\Factory\BattleFactory;
use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Domain\ValueObjects\BattleStatus;
use App\Battle\Application\UseCases\Contracts\BattleRepository as BattleRepositoryRepository;
use App\Shared\Adapters\Gateways\Contracts\DatabaseDriver;

class BattleRepository implements BattleRepositoryRepository
{
    private DatabaseDriver $connection;

    public function __construct(DatabaseDriver $connection)
    {
        $this->connection = $connection;
    }

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