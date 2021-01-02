<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCartTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cart');

        $table->addColumn('player_id', 'integer')
            ->addColumn('total', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('created_at', 'datetime')

            ->addForeignKey('player_id', 'players', 'id')
            ->create();
    }

    public function down(): void
    {
        $this->table('cart')->drop()->save();
    }
}
