<?php

declare(strict_types=1);

namespace App\Pokemon\UseCases\Contracts;

use App\Pokemon\Domain\Pokemon;

interface PokemonRepository
{
    public function get(int $pk): ?Pokemon;
    public function getByAlias(string $alias): ?Pokemon;
}
