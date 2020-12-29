<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBattleTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('battles');

        $table->addColumn('player1_id', 'integer')
            ->addColumn('pokemon1_id', 'integer')
            ->addColumn('player2_id', 'integer', ['null' => true])
            ->addColumn('pokemon2_id', 'integer')
            ->addColumn('xp_earned', 'integer', ['default' => 0])
            ->addColumn('money_earned', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('status', 'enum', ['values' => ['STARTED', 'FINISHED']])
            ->addColumn('created_at', 'datetime')
            ->addColumn('ended_at', 'datetime', ['null' => true])

            ->addForeignKey('player1_id', 'players', 'id')
            ->addForeignKey('player2_id', 'players', 'id')
            ->create();
    }

    public function down(): void
    {
        $this->table('battles')->drop()->save();
    }
}
