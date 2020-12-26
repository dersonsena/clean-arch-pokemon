<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Exceptions\InvalidGenderException;
use JsonSerializable;

final class Gender implements JsonSerializable
{
    public const MALE = 'MALE';
    public const FEMALE = 'FEMALE';

    private string $gender;

    public function __construct(string $gender)
    {
        if (!in_array($gender, [static::MALE, static::FEMALE])) {
            throw new InvalidGenderException();
        }

        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->gender;
    }

    public function jsonSerialize(): string
    {
        return $this->gender;
    }
}