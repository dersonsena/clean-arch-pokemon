<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PokedexSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'PlayerSeeder',
        ];
    }

    public function run()
    {
        $data = [
            ['player_id' => 1],
            ['player_id' => 2],
            ['player_id' => 3]
        ];

        $players = $this->table('pokedex');
        $players->insert($data)
            ->saveData();
    }
}
