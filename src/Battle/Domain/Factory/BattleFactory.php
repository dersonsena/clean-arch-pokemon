<?php

declare(strict_types=1);

namespace App\Battle\Domain\Factory;

use App\Battle\Domain\Battle;
use App\Battle\Domain\ValueObjects\BattleStatus;
use DateTimeImmutable;

final class BattleFactory
{
    public static function create(array $values = [])
    {
        $battle = new Battle();
        $battle->setCreatedAt(new DateTimeImmutable());
        $battle->setEndedAt(null);

        if (empty($values)) {
            return $battle;
        }

        if (isset($values['id'])) {
            $values['id'] = (int)$values['id'];
        }

        if (isset($values['created_at'])) {
            $values['created_at'] = new DateTimeImmutable($values['created_at']);
        }

        if (isset($values['status'])) {
            $battle->setStatus(new BattleStatus($values['status']));
            unset($values['status']);
        }

        if (isset($values['trainer1'])) {
            $battle->setTrainer1($values['trainer1']);
            unset($values['trainer1']);
        }

        if (isset($values['trainer2'])) {
            $battle->setTrainer2($values['trainer2']);
            unset($values['trainer2']);
        }

        if (isset($values['xp_earned'])) {
            $values['xp_earned'] = (int)$values['xp_earned'];
        }

        if (isset($values['money_earned'])) {
            $values['money_earned'] = (float)$values['money_earned'];
        }

        $battle->fill($values);

        return $battle;
    }
}
