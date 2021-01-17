<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePokedexPokemonsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('pokedex_pokemons');

        $table->addColumn('pokedex_id', 'integer')
            ->addColumn('pokemon_id', 'integer')
            ->addColumn('captured', 'boolean', ['default' => false])

            ->addForeignKey('pokedex_id', 'pokedex', 'id')
            ->addForeignKey('pokemon_id', 'pokemons', 'id')
            ->create();
    }

    public function down(): void
    {
        $this->table('pokedex_pokemons')->drop()->save();
    }
}
