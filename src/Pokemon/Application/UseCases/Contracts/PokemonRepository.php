<?php

declare(strict_types=1);

namespace App\Pokemon\Application\UseCases\Contracts;

use App\Pokemon\Domain\Pokemon;

interface PokemonRepository
{
    public function get(int $pk): ?Pokemon;
    public function getByApiId(int $id): ?Pokemon;
}