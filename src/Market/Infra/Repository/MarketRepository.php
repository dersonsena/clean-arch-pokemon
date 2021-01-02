<?php

declare(strict_types=1);

namespace App\Market\Infra\Repository;

use App\Market\Domain\Cart;
use App\Market\Domain\Factory\ItemFactory;
use App\Market\Domain\Item;
use App\Market\Application\UseCases\Contracts\MarketRepository as MarketRepositoryInterface;
use App\Market\Infra\Exceptions\DbException;
use App\Shared\Contracts\DatabaseConnection;
use PDOException;

class MarketRepository implements MarketRepositoryInterface
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function purchase(Cart $cart): bool
    {
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
                    'market_item_id' => $item->getItem()->getId(),
                    'name' => $item->getName(),
                    'price' => $item->getPrice(),
                    'quantity' => $item->getQuantity(),
                    'total' => $item->getTotal()
                ];
            }

            $this->connection
                ->setTable('cart_items')
                ->batchInsert(array_keys($values[0]), $values);

            $this->connection->commit();

            return true;
        } catch (PDOException $e) {
            $this->connection->rollback();

            throw new DbException(
                'Erro ao criar carrinho de compras',
                ['code' => $e->getCode(), 'message' => $e->getMessage()]
            );
        }
    }

    public function getMartItem(int $id): ?Item
    {
        $row = $this->connection->setTable('mart_items')
            ->select(['conditions' => ['id' => $id]])
            ->fetchOne();

        if (!$row) {
            return null;
        }

        return ItemFactory::create($row);
    }

    public function getMarketItems(array $conditions = []): array
    {
        return $this->connection->setTable('mart_items')
            ->select([])
            ->fetchAll();
    }
}