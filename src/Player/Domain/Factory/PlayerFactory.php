<?php

declare(strict_types=1);

namespace App\Player\Domain\Factory;

use App\Bag\Domain\Factory\BagFactory;
use App\Player\Domain\Player;

final class PlayerFactory
{
    public static function create(array $values = [])
    {
        $player = new Player();
        $player->setBag(BagFactory::create());

        if (empty($values)) {
            return $player;
        }

        $player->fill($values);

        return $player;
    }
}