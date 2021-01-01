<?php

declare(strict_types=1);

namespace App\Player\Application\UseCases\Contracts;

use App\Player\Domain\Player;

interface PlayerRepository
{
    public function get(int $pk): ?Player;
    public function debitMoney(Player $player, float $money): bool;
    public function addIntoBag(Player $player, array $items): bool;
}