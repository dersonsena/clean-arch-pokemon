<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMartItemsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('mart_items');

        $table->addColumn('name', 'string', ['limit' => 60])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('category', 'enum', ['values' => ['DEFAULT', 'POKEBALL'], 'default' => 'DEFAULT'])
            ->addColumn('created_at', 'datetime')
            ->addColumn('is_salable', 'boolean', ['default' => true])
            ->create();
    }
}
