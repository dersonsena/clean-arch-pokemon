<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Factory\PlayerFactory;
use App\Player\Domain\Player;
use App\Player\UseCases\Contracts\PlayerRepository as PlayerRepositoryInterface;
use App\Shared\Domain\ValueObjects\Gender;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function addIntoBag(Player $player, array $items): bool
    {
        return true;
    }

    public function debitMoney(Player $player, float $money): bool
    {
        $player->debitMoney($money);
        return true;
    }

    public function get(int $pk): ?Player
    {
        return PlayerFactory::create([
            'name' => 'Ash Ketchum',
            'avatar' => 'https://i1.sndcdn.com/avatars-000740962879-t7ox4k-t500x500.jpg',
            'gender' => Gender::MALE,
            'xp' => 100,
            'money' => 30000
        ]);
    }
}