<?php

declare(strict_types=1);

namespace App\Battle\UseCases\StartBattle;

use App\Shared\Helpers\DTO;

final class InputBoundary extends DTO
{
    protected int $trainerId;
    protected string $trainerPokemonAlias;
    protected ?int $challengerId;
    protected string $challengerPokemonAlias;

    public function getTrainerId(): int
    {
        return $this->trainerId;
    }

    public function getTrainerPokemonAlias(): string
    {
        return $this->trainerPokemonAlias;
    }

    public function getChallengerId(): ?int
    {
        return $this->challengerId;
    }

    public function getChallengerPokemonAlias(): string
    {
        return $this->challengerPokemonAlias;
    }
}
