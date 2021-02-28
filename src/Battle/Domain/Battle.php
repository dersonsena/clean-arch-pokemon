<?php

declare(strict_types=1);

namespace App\Battle\Domain;

use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Domain\ValueObjects\BattleStatus;
use App\Shared\Domain\Entity;
use DateTimeInterface;

final class Battle extends Entity
{
    protected BattlePokemon $trainer1;
    protected BattlePokemon $trainer2;
    protected int $xpEarned = 0;
    protected float $moneyEarned = 0;
    protected BattleStatus $status;
    protected DateTimeInterface $createdAt;
    protected ?DateTimeInterface $endedAt;

    /**
     * @return BattlePokemon
     */
    public function getTrainer1(): BattlePokemon
    {
        return $this->trainer1;
    }

    /**
     * @param BattlePokemon $trainer1
     * @return Battle
     */
    public function setTrainer1(BattlePokemon $trainer1): Battle
    {
        $this->trainer1 = $trainer1;
        return $this;
    }

    /**
     * @return BattlePokemon
     */
    public function getTrainer2(): BattlePokemon
    {
        return $this->trainer2;
    }

    /**
     * @param BattlePokemon $trainer2
     * @return Battle
     */
    public function setTrainer2(BattlePokemon $trainer2): Battle
    {
        $this->trainer2 = $trainer2;
        return $this;
    }

    /**
     * @return int
     */
    public function getXpEarned(): int
    {
        return $this->xpEarned;
    }

    /**
     * @param int $xpEarned
     * @return Battle
     */
    public function setXpEarned(int $xpEarned): Battle
    {
        $this->xpEarned = $xpEarned;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getMoneyEarned()
    {
        return $this->moneyEarned;
    }

    /**
     * @param float|int $moneyEarned
     * @return Battle
     */
    public function setMoneyEarned($moneyEarned)
    {
        $this->moneyEarned = $moneyEarned;
        return $this;
    }

    /**
     * @return BattleStatus
     */
    public function getStatus(): BattleStatus
    {
        return $this->status;
    }

    /**
     * @param BattleStatus $status
     * @return Battle
     */
    public function setStatus(BattleStatus $status): Battle
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return Battle
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Battle
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndedAt(): ?DateTimeInterface
    {
        return $this->endedAt;
    }

    /**
     * @param DateTimeInterface|null $endedAt
     * @return Battle
     */
    public function setEndedAt(?DateTimeInterface $endedAt): Battle
    {
        $this->endedAt = $endedAt;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            ...$this->toArray(),
            'createdAt' => $this->createdAt->format(DATE_ATOM),
            'endedAt' => $this->endedAt ? $this->endedAt->format(DATE_ATOM) : null,
        ];
    }
}
