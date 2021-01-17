<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePokedexTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('pokedex');

        $table->addColumn('player_id', 'integer')
            ->addForeignKey('player_id', 'players', 'id')
            ->create();
    }

    public function down(): void
    {
        $this->table('pokedex')->drop()->save();
    }
}
