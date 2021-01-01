<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\StartBattle;

use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Application\UseCases\Contracts\BattleRepository;
use App\Player\Domain\Exceptions\PlayerNotFoundException;
use App\Player\Application\UseCases\Contracts\PlayerRepository;
use App\Pokemon\Domain\Exceptions\PokemonNotFoundException;
use App\Pokemon\Application\UseCases\Contracts\PokemonRepository;

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
        // A REQUEST deverá enviar o ID da base de dados e não da API de terceiros
        // refatorar para poder receber o ID da base de dados
        $trainer = $this->playerRepository->get($input->getTrainerId());

        if (!$trainer) {
            throw new PlayerNotFoundException();
        }

        $pokemon = $this->pokemonRepository->get($input->getTrainerPokemonId());

        if (!$pokemon) {
            throw new PokemonNotFoundException();
        }

        $challenger = $this->playerRepository->get($input->getChallengerId());
        $pokemonChallenger = $this->pokemonRepository->get($input->getChallengerPokemonId());

        if (!$pokemonChallenger) {
            throw new PokemonNotFoundException('Pokémon do desafiante não foi encontrado.');
        }

        $battle = $this->battleRepository->start(
            new BattlePokemon($pokemon, $trainer),
            new BattlePokemon($pokemonChallenger, $challenger)
        );

        return OutputBoundery::build(['battle' => $battle->toArray()]);
    }
}