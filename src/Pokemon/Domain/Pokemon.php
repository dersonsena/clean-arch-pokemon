<?php

declare(strict_types=1);

namespace App\Pokemon\Domain;

use App\Shared\Domain\Entity;

final class Pokemon extends Entity
{
    protected string $name;
    protected int $number;
    protected float $height;
    protected float $weight;
    protected string $image;
    protected Type $type;
    protected int $level;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Pokemon
     */
    public function setName(string $name): Pokemon
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Pokemon
     */
    public function setNumber(int $number): Pokemon
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @param float $height
     * @return Pokemon
     */
    public function setHeight(float $height): Pokemon
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return Pokemon
     */
    public function setWeight(float $weight): Pokemon
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Pokemon
     */
    public function setImage(string $image): Pokemon
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return Pokemon
     */
    public function setType(Type $type): Pokemon
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return Pokemon
     */
    public function setLevel(int $level): Pokemon
    {
        $this->level = $level;
        return $this;
    }
}