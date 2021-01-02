<?php

declare(strict_types=1);

namespace App\Market\Domain\ValueObjects;

use App\Market\Domain\Exceptions\InvalidItemCategoryException;
use JsonSerializable;

final class Category implements JsonSerializable
{
    public const DEFAULT = 'DEFAULT';
    public const POKEBALL = 'POKEBALL';

    private string $name;

    public function __construct(string $name)
    {
        if (!in_array($name, [self::DEFAULT, self::POKEBALL])) {
            throw new InvalidItemCategoryException($name);
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->__toString();
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }
}