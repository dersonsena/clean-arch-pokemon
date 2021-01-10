<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Exceptions\PlayerNotFoundException;
use App\Player\Domain\Factory\PlayerFactory;
use App\Player\Domain\Player;
use App\Player\Application\UseCases\Contracts\PlayerRepository as PlayerRepositoryInterface;
use App\Shared\Contracts\DatabaseConnection;

class PlayerRepository implements PlayerRepositoryInterface
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function addIntoBag(Player $player, array $items): bool
    {
        foreach ($items as $item) {
            $player->getBag()->addItem($item);
        }

        return true;
    }

    public function debitMoney(Player $player, float $money): bool
    {
        $newMoney = $player->getMoney() - $money;
        $newMoney = $newMoney >= 0 ? $newMoney : 0;

        $this->connection->setTable('players')->update(
            ['money' => $newMoney],
            ['id' => $player->getId()]
        );

        $player->debitMoney($money);

        return true;
    }

    public function get(int $pk): ?Player
    {
        $row = $this->connection
            ->setTable('players')
            ->select(['conditions' => ['id' => $pk]])
            ->fetchOne();

        if (is_null($row)) {
            throw new PlayerNotFoundException(['id' => 'invalid', 'informed_entry' => $pk]);
        }

        return PlayerFactory::create($row);
    }
}