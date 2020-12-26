<?php

declare(strict_types=1);

namespace App\Player\Domain\Factory;

use App\Player\Domain\Player;
use App\Shared\Domain\ValueObjects\Gender;

final class PlayerFactory
{
    public static function create(array $values = []): Player
    {
        $player = new Player();
        $player->setBag(BagFactory::create());

        if (empty($values)) {
            return $player;
        }

        if (isset($values['gender'])) {
            $player->setGender(new Gender($values['gender']));
            unset($values['gender']);
        }

        $player->fill($values);

        return $player;
    }
}