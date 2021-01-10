<?php

declare(strict_types=1);

namespace App\Market\Infra\Repository;

use App\Market\Domain\Cart;
use App\Market\Domain\Exceptions\CreatePurchaseException;
use App\Market\Domain\Exceptions\InsufficientMoneyException;
use App\Market\Domain\Exceptions\MartItemNotFoundException;
use App\Market\Domain\Factory\ItemFactory;
use App\Market\Domain\Item;
use App\Market\Application\UseCases\Contracts\MarketRepository as MarketRepositoryInterface;
use App\Player\Application\UseCases\Contracts\PlayerRepository;
use App\Player\Domain\Exceptions\AddItemToBagException;
use App\Player\Domain\Player;
use App\Shared\Contracts\DatabaseConnection;
use PDOException;

class MarketRepository implements MarketRepositoryInterface
{
    private DatabaseConnection $connection;
    private PlayerRepository $playerRepository;

    public function __construct(
        DatabaseConnection $connection,
        PlayerRepository $playerRepository
    ) {
        $this->connection = $connection;
        $this->playerRepository = $playerRepository;
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
            $this->connection->setTable('cart')->insert([
                'player_id' => $cart->getPlayer()->getId(),
                'total' => $cart->getTotal(),
                'created_at' => $cart->getCreatedAt()->format('Y-m-d H:i:s')
            ]);

            $cartId = (int)$this->connection->lastInsertId();
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

            $this->connection
                ->setTable('cart_items')
                ->batchInsert(array_keys($values[0]), $values);

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
        $row = $this->connection->setTable('mart_items')
            ->select(['conditions' => ['id' => $id]])
            ->fetchOne();

        if (!$row) {
            throw new MartItemNotFoundException(['id' => 'invalid', 'informed_entry' => $id]);
        }

        return ItemFactory::create($row);
    }

    public function getMarketItems(array $conditions = []): array
    {
        $items = [];

        $rows = $this->connection->setTable('mart_items')
            ->select([])
            ->orderBy('name ASC, price ASC')
            ->fetchAll();

        foreach ($rows as $row) {
            $items[] = ItemFactory::create($row)->toArray();
        }

        return $items;
    }
}