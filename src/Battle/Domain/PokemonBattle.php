<?php

declare(strict_types=1);

namespace App\Battle\Domain;

use App\Battle\Domain\ValueObjects\BattleStatus;
use App\Player\Domain\Player;
use App\Pokemon\Domain\Pokemon;
use App\Shared\Domain\Entity;
use DateTimeInterface;

final class PokemonBattle extends Entity
{
    protected Player $player;
    protected Pokemon $playerPokemon;
    protected Pokemon $challengerPokemon;
    protected BattleStatus $status;
    protected DateTimeInterface $createdAt;
    protected DateTimeInterface $endedAt;

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return PokemonBattle
     */
    public function setPlayer(Player $player): PokemonBattle
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return Pokemon
     */
    public function getPlayerPokemon(): Pokemon
    {
        return $this->playerPokemon;
    }

    /**
     * @param Pokemon $playerPokemon
     * @return PokemonBattle
     */
    public function setPlayerPokemon(Pokemon $playerPokemon): PokemonBattle
    {
        $this->playerPokemon = $playerPokemon;
        return $this;
    }

    /**
     * @return Pokemon
     */
    public function getChallengerPokemon(): Pokemon
    {
        return $this->challengerPokemon;
    }

    /**
     * @param Pokemon $challengerPokemon
     * @return PokemonBattle
     */
    public function setChallengerPokemon(Pokemon $challengerPokemon): PokemonBattle
    {
        $this->challengerPokemon = $challengerPokemon;
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
     * @return PokemonBattle
     */
    public function setStatus(BattleStatus $status): PokemonBattle
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
     * @return PokemonBattle
     */
    public function setCreatedAt(DateTimeInterface $createdAt): PokemonBattle
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEndedAt(): DateTimeInterface
    {
        return $this->endedAt;
    }

    /**
     * @param DateTimeInterface $endedAt
     * @return PokemonBattle
     */
    public function setEndedAt(DateTimeInterface $endedAt): PokemonBattle
    {
        $this->endedAt = $endedAt;
        return $this;
    }
}