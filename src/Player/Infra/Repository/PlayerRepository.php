<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Factory\PlayerFactory;
use App\Player\Domain\Player;
use App\Player\UseCases\Contracts\PlayerRepository as PlayerRepositoryInterface;
use App\Shared\Contracts\DatabaseConnection;
use App\Shared\Domain\ValueObjects\Gender;

class PlayerRepository implements PlayerRepositoryInterface
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

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
        $row = $this->connection
            ->setTable('players')
            ->select(['conditions' => ['id' => $pk]])
            ->fetchOne();

        if (!$row) {
            return null;
        }

        return PlayerFactory::create($row);
    }
}