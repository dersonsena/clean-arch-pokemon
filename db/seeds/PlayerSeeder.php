<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PlayerSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'name' => 'Ash Ketchum',
                'avatar' => 'https://i1.sndcdn.com/avatars-000740962879-t7ox4k-t500x500.jpg',
                'gender' => 'MALE',
                'xp' => 100,
                'money' => 1000,
            ],
            [
                'name' => 'Gary Carvalho',
                'avatar' => 'https://cdn.bulbagarden.net/upload/thumb/4/4a/Gary_Oak_DP.png/220px-Gary_Oak_DP.png',
                'gender' => 'MALE',
                'xp' => 500,
                'money' => 4000,
            ],
            [
                'name' => 'Misty',
                'avatar' => 'https://gartic.com.br/imgs/mural/um/umbreon__/misty-p-deadmisaki.png',
                'gender' => 'FEMALE',
                'xp' => 230,
                'money' => 2500,
            ],
        ];

        $players = $this->table('players');
        $players->insert($data)
            ->saveData();
    }
}
