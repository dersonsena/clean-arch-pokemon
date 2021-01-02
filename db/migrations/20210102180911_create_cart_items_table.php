<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCartItemsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cart_items');

        $table->addColumn('cart_id', 'integer')
            ->addColumn('mart_item_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 60])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('quantity', 'integer')
            ->addColumn('total', 'decimal', ['precision' => 10, 'scale' => 2])

            ->addForeignKey('cart_id', 'cart', 'id')
            ->addForeignKey('mart_item_id', 'mart_items', 'id')
            ->create();
    }

    public function down(): void
    {
        $this->table('cart_items')->drop()->save();
    }
}
