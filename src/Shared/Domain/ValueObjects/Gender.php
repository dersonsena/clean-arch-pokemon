<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Exceptions\InvalidGenderException;

final class Gender
{
    public const MALE = 'M';
    public const FEMALE = 'F';

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
}