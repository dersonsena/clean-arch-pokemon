<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\StartBattle;

use App\Shared\Helpers\DTO;

final class OutputBoundary extends DTO
{
    protected int $id;
    protected int $xpEarned;
    protected float $moneyEarned;
    protected string $status;
    protected string $createdAt;
    protected ?string $endedAt;
    protected ?array $challenger;
    protected array $challengerPokemon;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getXpEarned(): int
    {
        return $this->xpEarned;
    }

    /**
     * @return float
     */
    public function getMoneyEarned(): float
    {
        return $this->moneyEarned;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getEndedAt():? string
    {
        return $this->endedAt;
    }

    /**
     * @return array
     */
    public function getChallenger():? array
    {
        return $this->challenger;
    }

    /**
     * @return array
     */
    public function getChallengerPokemon(): array
    {
        return $this->challengerPokemon;
    }
}
