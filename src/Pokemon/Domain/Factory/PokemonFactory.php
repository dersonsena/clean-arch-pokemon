<?php

declare(strict_types=1);

namespace App\Pokemon\Domain\Factory;

use App\Pokemon\Domain\Pokemon;

final class PokemonFactory
{
    public static function create(array $values = []): Pokemon
    {
        $pokemon = new Pokemon();

        if (empty($values)) {
            return $pokemon;
        }

        if (isset($values['type'])) {
            $pokemon->setType(TypeFactory::create($values['type']));
            unset($values['type']);
        }

        $pokemon->fill($values);

        return $pokemon;
    }
}