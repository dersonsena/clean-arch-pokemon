<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePlayersTable extends AbstractMigration
{
    public function change(): void
    {
        $players = $this->table('players');

        $players->addColumn('name', 'string', ['limit' => 60])
            ->addColumn('avatar', 'string', ['limit' => 150, 'null' => true])
            ->addColumn('gender', 'enum', ['values' => ['MALE', 'FEMALE']])
            ->addColumn('xp', 'integer', ['default' => 0])
            ->addColumn('money', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->create();
    }
}
