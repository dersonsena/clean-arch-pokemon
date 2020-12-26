<?php

declare(strict_types=1);

namespace App\Pokemon\Infra\Repository;

use App\Pokemon\Domain\Factory\PokemonFactory;
use App\Pokemon\Domain\Pokemon;
use App\Pokemon\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;

class PokemonRepository implements PokemonRepositoryInterface
{
    public function get(int $id): ?Pokemon
    {
        return PokemonFactory::create([
            'name' => 'Ditto',
            'number' => 203,
            'height' => 3,
            'weight' => 40,
            'image' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/132.png',
            'type' => [
                'name' => 'Normal'
            ],
            'level' => 10
        ]);
    }
}