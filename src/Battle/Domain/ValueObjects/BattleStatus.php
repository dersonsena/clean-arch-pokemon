<?php

declare(strict_types=1);

namespace App\Battle\Domain\ValueObjects;

use InvalidArgumentException;

final class BattleStatus implements \JsonSerializable
{
    public const STARTED = 'S';
    public const FINISHED = 'F';

    private string $status;

    public function __construct(string $status)
    {
        if (!in_array($status, [static::STARTED, static::FINISHED])) {
            throw new InvalidArgumentException('Status de Batalha inválido');
        }
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