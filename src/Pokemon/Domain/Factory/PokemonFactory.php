<?php

declare(strict_types=1);

namespace App\Pokemon\Domain\Factory;

use App\Pokemon\Domain\Pokemon;

final class PokemonFactory
{
    public static function create(array $values = []): Pokemon
    {
        $pokemon = new Pokemon();
        $pokemon->setType(TypeFactory::create());

        if (empty($values)) {
            return $pokemon;
        }

        if (isset($values['id'])) {
            $values['id'] = (int)$values['id'];
        }

        if (isset($values['number'])) {
            $values['number'] = (int)$values['number'];
        }

        if (isset($values['height'])) {
            $values['height'] = (float)$values['height'];
        }

        if (isset($values['weight'])) {
            $values['weight'] = (float)$values['weight'];
        }

        if (isset($values['level'])) {
            $values['level'] = (int)$values['level'];
        }

        if (isset($values['type'])) {
            $pokemon->setType(TypeFactory::create($values['type']));
            unset($values['type']);
        }

        $pokemon->fill($values);

        return $pokemon;
    }
}