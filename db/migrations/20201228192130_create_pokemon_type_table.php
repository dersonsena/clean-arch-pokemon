<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePokemonTypeTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('pokemon_types');

        $table->addColumn('name', 'string', ['limit' => 100])
            ->addIndex(['name'], ['unique' => true])
            ->create();
    }

    public function down(): void
    {
        $this->table('pokemon_types')->drop()->save();
    }
}
