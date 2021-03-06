<?php

declare(strict_types=1);

namespace App\Market\Adapters\Repository;

use App\Market\Domain\Cart;
use App\Market\Domain\Exceptions\CreatePurchaseException;
use App\Market\Domain\Exceptions\InsufficientMoneyException;
use App\Market\Domain\Exceptions\MartItemNotFoundException;
use App\Market\Domain\Factory\ItemFactory;
use App\Market\Domain\Item;
use App\Market\UseCases\Contracts\MarketRepository as MarketRepositoryInterface;
use App\Player\UseCases\Contracts\PlayerRepository;
use App\Player\Domain\Player;
use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use PDOException;

class MarketRepository implements MarketRepositoryInterface
{
    private DatabaseDriver $connection;
    private PlayerRepository $playerRepository;
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;

    public function __construct(
        DatabaseDriver $connection,
        PlayerRepository $playerRepository,
        SelectStatement $selectStatement,
        InsertStatement $insertStatement
    ) {
        $this->connection = $connection;
        $this->playerRepository = $playerRepository;
        $this->insertStatement = $insertStatement;
        $this->selectStatement = $selectStatement;
    }

    public function purchase(Cart $cart, Player $player): bool
    {
        if (!$player->hasSufficientMoneyToPurchase($cart->getTotal())) {
            throw new InsufficientMoneyException([
                'purchase_total' => $cart->getTotal(),
                'player_balance' => $player->getMoney()
            ]);
        }

        $this->connection->beginTransaction();

        try {
            $cartId = $this->insertStatement
                ->into('cart')
                ->values([
                    'player_id' => $cart->getPlayer()->getId(),
                    'total' => $cart->getTotal(),
                    'created_at' => $cart->getCreatedAt()->format('Y-m-d H:i:s')
                ])
                ->insert();

            $values = [];

            foreach ($cart->getItems() as $item) {
                $values[] = [
                    'cart_id' => $cartId,
                    'mart_item_id' => $item->getItem()->getId(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'quantity' => $item->getQuantity(),
                    'total' => $item->getTotal()
                ];
            }

            $this->insertStatement
                ->into('cart_items')
                ->values($values)
                ->batchInsert();

            $this->playerRepository->debitMoney($player, $cart->getTotal());
            $this->playerRepository->addIntoBag($player, $cart->getMartItemsList());

            if (!$this->connection->commit()) {
                $this->connection->rollback();
                throw new CreatePurchaseException(['cart' => $cart]);
            }

            return true;

        } catch (PDOException $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    public function getMartItem(int $id): ?Item
    {
        $row = $this->selectStatement
            ->select()
            ->from('mart_items')
            ->where('id', $id)
            ->fetchOne();

        if (!$row) {
            throw new MartItemNotFoundException(['id' => 'invalid', 'informed_entry' => $id]);
        }

        return ItemFactory::create($row);
    }

    public function getMarketItems(array $conditions = []): array
    {
        $items = [];

        $query = $this->selectStatement
            ->select()
            ->from('mart_items')
            ->orderBy(['name ASC', 'price ASC']);

        foreach($conditions as $column => $value) {
            $query->where($column, $value);
        }

        $rows = $query->fetchAll();

        foreach ($rows as $row) {
            $items[] = ItemFactory::create($row)->toArray();
        }

        return $items;
    }
}
