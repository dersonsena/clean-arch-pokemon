<?php

declare(strict_types=1);

namespace App\Battle\UseCases;

use App\Battle\UseCases\Contracts\StartBattleRepository;
use App\Player\UseCases\Contracts\FindPlayerByPKRepository;
use App\Player\Domain\Exceptions\PlayerNotFoundException;

final class StartBattle
{
    private StartBattleRepository $startBattleRepository;
    private FindPlayerByPKRepository $findPlayerByPKRepository;

    public function __construct(
        StartBattleRepository $startBattleRepository,
        FindPlayerByPKRepository $findPlayerByPKRepository
    ) {
        $this->startBattleRepository = $startBattleRepository;
        $this->findPlayerByPKRepository = $findPlayerByPKRepository;
    }

    public function handle(InputBoundery $input): OutputBoundery
    {
        $player = $this->findPlayerByPKRepository->get((int)$input->getPlayerId());

        if (!$player) {
            throw new PlayerNotFoundException();
        }
    }
}