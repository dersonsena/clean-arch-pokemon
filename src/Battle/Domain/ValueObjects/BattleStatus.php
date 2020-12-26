<?php

declare(strict_types=1);

namespace App\Battle\Domain\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

final class BattleStatus implements JsonSerializable
{
    public const STARTED = 'STARTED';
    public const FINISHED = 'FINISHED';

    private string $status;

    public function __construct(string $status)
    {
        if (!in_array($status, [static::STARTED, static::FINISHED])) {
            throw new InvalidArgumentException('Status de Batalha inválido');
        }

        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function jsonSerialize(): string
    {
        return $this->status;
    }
}