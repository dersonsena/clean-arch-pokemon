<?php

declare(strict_types=1);

namespace App\Pokedex\Application\UseCases\Contracts;

use App\Pokedex\Domain\Pokemon;

interface PokemonRepository
{
    /**
     * @param array $params
     * @return Pokemon[]
     */
    public function search(array $params): array;
    public function get(int $pk): ?Pokemon;
    public function getByAlias(string $alias): ?Pokemon;
}