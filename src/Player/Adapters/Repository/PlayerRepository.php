<?php

declare(strict_types=1);

namespace App\Player\Adapters\Repository;

use App\Player\Domain\Exceptions\PlayerNotFoundException;
use App\Player\Domain\Factory\PlayerFactory;
use App\Player\Domain\Player;
use App\Player\Application\UseCases\Contracts\PlayerRepository as PlayerRepositoryInterface;
use App\Shared\Adapters\Gateways\Contracts\DatabaseDriver;
use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\UpdateStatement;

class PlayerRepository implements PlayerRepositoryInterface
{
    private DatabaseDriver $connection;
    private SelectStatement $selectStatement;
    private UpdateStatement $updateStatement;

    public function __construct(
        DatabaseDriver $connection,
        SelectStatement $select,
        UpdateStatement $updateStatement
    ) {
        $this->connection = $connection;
        $this->selectStatement = $select;
        $this->updateStatement = $updateStatement;
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

        $this->updateStatement
            ->table('players')
            ->values(['money' => $newMoney])
            ->conditions(['id' => $player->getId()])
            ->update();

        $player->debitMoney($money);

        return true;
    }

    public function get(int $pk): ?Player
    {
        $record = $this->selectStatement
            ->select()
            ->from('players')
            ->where('id', $pk)
            ->fetchOne();

        if (is_null($record)) {
            throw new PlayerNotFoundException(['id' => 'invalid', 'informed_entry' => $pk]);
        }

        return PlayerFactory::create($record);
    }

    public function profileInfo(int $playerId): array
    {
        return $this->get($playerId)->toArray();
    }
}
