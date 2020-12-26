<?php

declare(strict_types=1);

namespace App\Battle\UseCases\StartBattle;

use App\Shared\UseCases\DTO;

final class InputBoundery extends DTO
{
    protected int $trainerId;
    protected int $trainerPokemonId;
    protected ?int $challengerId;
    protected int $challengerPokemonId;

    /**
     * @return int
     */
    public function getTrainerId(): int
    {
        return $this->trainerId;
    }

    /**
     * @return int
     */
    public function getTrainerPokemonId(): int
    {
        return $this->trainerPokemonId;
    }

    /**
     * @return int
     */
    public function getChallengerId(): ?int
    {
        return $this->challengerId;
    }

    /**
     * @return int
     */
    public function getChallengerPokemonId(): int
    {
        return $this->challengerPokemonId;
    }
}