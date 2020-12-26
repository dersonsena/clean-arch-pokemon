<?php

declare(strict_types=1);

namespace App\Pokemon\UseCases\Contracts;

use App\Pokemon\Domain\Pokemon;

interface FindPokemonById
{
    public function get(int $id): ?Pokemon;
}