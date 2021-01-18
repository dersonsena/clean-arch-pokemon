<?php

declare(strict_types=1);

namespace App\Pokedex\Domain\Factory;

use App\Player\Domain\Factory\PlayerFactory;
use App\Pokedex\Domain\Pokedex;

final class PokedexFactory
{
    public static function create(array $values = []): Pokedex
    {
        $pokedex = new Pokedex();
        $pokedex->setPlayer(PlayerFactory::create());

        if (empty($values)) {
            return $pokedex;
        }

        if (isset($values['id'])) {
            $values['id'] = (int)$values['id'];
        }

        $pokedex->fill($values);

        return $pokedex;
    }
}