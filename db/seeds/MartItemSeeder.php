<?php

declare(strict_types=1);

use App\Market\Domain\ValueObjects\Category;
use Phinx\Seed\AbstractSeed;

class MartItemSeeder extends AbstractSeed
{
    public function run()
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $data = [
            [
                'name' => 'Antidote',
                'price' => 100,
                'category' => Category::DEFAULT,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Burn Heal',
                'price' => 250,
                'category' => Category::DEFAULT,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Dire Hit',
                'price' => 650,
                'category' => Category::DEFAULT,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Escape Rope',
                'price' => 550,
                'category' => Category::DEFAULT,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Fresh Water',
                'price' => 200,
                'category' => Category::DEFAULT,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Poke Ball',
                'price' => 200,
                'category' => Category::POKEBALL,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Great Ball',
                'price' => 200,
                'category' => Category::POKEBALL,
                'created_at' => $now,
                'is_salable' => true,
            ],
            [
                'name' => 'Master Ball',
                'price' => 200,
                'category' => Category::POKEBALL,
                'created_at' => $now,
                'is_salable' => false,
            ],
        ];

        $table = $this->table('mart_items');
        $table->insert($data)
            ->saveData();
    }
}
