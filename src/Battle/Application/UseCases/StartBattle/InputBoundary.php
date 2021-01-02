<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\StartBattle;

use App\Shared\Helpers\DTO;

final class InputBoundery extends DTO
{
    protected int $trainerId;
    protected int $trainerPokemonAlias;
    protected ?int $challengerId;
    protected int $challengerPokemonAlias;

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
    public function getTrainerPokemonAlias(): int
    {
        return $this->trainerPokemonAlias;
    }

    /**
     * @return int|null
     */
    public function getChallengerId(): ?int
    {
        return $this->challengerId;
    }

    /**
     * @return int
     */
    public function getChallengerPokemonAlias(): int
    {
        return $this->challengerPokemonAlias;
    }
}