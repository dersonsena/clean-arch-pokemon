<?php

declare(strict_types=1);

namespace App\Battle\UseCases\StartBattle;

use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Infra\Repositories\BattleRepository;
use App\Player\Domain\Exceptions\PlayerNotFoundException;
use App\Player\UseCases\Contracts\PlayerRepository;
use App\Pokemon\Domain\Exceptions\PokemonNotFoundException;
use App\Pokemon\UseCases\Contracts\PokemonRepository;

final class StartBattle
{
    private PlayerRepository $playerRepository;
    private BattleRepository $battleRepository;
    private PokemonRepository $pokemonRepository;

    public function __construct(
        BattleRepository $battleRepository,
        PlayerRepository $playerRepository,
        PokemonRepository $pokemonRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->battleRepository = $battleRepository;
        $this->pokemonRepository = $pokemonRepository;
    }

    public function handle(InputBoundery $input): OutputBoundery
    {
        $trainer = $this->playerRepository->get((int)$input->getTrainerId());

        if (!$trainer) {
            throw new PlayerNotFoundException();
        }

        $pokemon = $this->pokemonRepository->get((int)$input->getTrainerPokemonId());

        if (!$pokemon) {
            throw new PokemonNotFoundException();
        }

        $challenger = $this->playerRepository->get((int)$input->getChallengerId());
        $pokemonChallenger = $this->pokemonRepository->get((int)$input->getChallengerPokemonId());

        if (!$pokemonChallenger) {
            throw new PokemonNotFoundException('Pokémon desafiante não foi encontrado.');
        }

        $battle = $this->battleRepository->start(
            new BattlePokemon($pokemon, $trainer),
            new BattlePokemon($pokemonChallenger, $challenger)
        );

        return OutputBoundery::build(['battle' => $battle->toArray()]);
    }
}