<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePokemonTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('pokemons');

        $table->addColumn('type_id', 'integer')
            ->addColumn('api_id', 'integer', ['null' => true])
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('number', 'integer')
            ->addColumn('height', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('weight', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('image', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('level', 'integer')

            ->addForeignKey('type_id', 'pokemon_types', 'id')
            ->create();
    }

    public function down(): void
    {
        $this->table('pokemons')->drop()->save();
    }
}
