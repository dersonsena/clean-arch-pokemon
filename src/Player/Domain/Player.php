<?php

declare(strict_types=1);

namespace App\Player\Domain;

use App\Shared\Domain\Entity;
use App\Shared\Domain\ValueObjects\Gender;

final class Player extends Entity
{
    protected string $name;
    protected string $avatar;
    protected Gender $gender;
    protected int $xp = 0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Player
     */
    public function setName(string $name): Player
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return Player
     */
    public function setAvatar(string $avatar): Player
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return Gender
     */
    public function getGender(): Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender $gender
     * @return Player
     */
    public function setGender(Gender $gender): Player
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return int
     */
    public function getXp(): int
    {
        return $this->xp;
    }

    /**
     * @param int $xp
     * @return Player
     */
    public function setXp(int $xp): Player
    {
        $this->xp = $xp;
        return $this;
    }
}