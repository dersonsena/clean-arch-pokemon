<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddPokemonsAliasColumn extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('pokemons');

        $table->addColumn('alias', 'string', ['after' => 'name'])
            ->update();
    }
}
