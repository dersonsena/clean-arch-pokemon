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
        $player->setParty(PartyFactory::create());

        if (empty($values)) {
            return $player;
        }

        if (isset($values['id'])) {
            $values['id'] = (int)$values['id'];
        }

        if (isset($values['bag'])) {
            $values['bag'] = BagFactory::create($values['bag']);
        }

        if (isset($values['party'])) {
            $values['party'] = PartyFactory::create($values['party']);
        }

        if (isset($values['xp'])) {
            $values['xp'] = (int)$values['xp'];
        }

        if (isset($values['money'])) {
            $values['money'] = (float)$values['money'];
        }

        if (isset($values['gender'])) {
            $player->setGender(new Gender($values['gender']));
            unset($values['gender']);
        }

        $player->fill($values);

        return $player;
    }
}