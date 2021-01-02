<?php

declare(strict_types=1);

namespace App\Player\Domain\Factory;

use App\Player\Domain\Party;

final class PartyFactory
{
    public static function create(array $values = []): Party
    {
        $party = new Party();

        if (empty($values)) {
            return $party;
        }

        $party->fill($values);

        return $party;
    }
}