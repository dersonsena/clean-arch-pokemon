<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\StartBattle;

use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Application\UseCases\Contracts\BattleRepository;
use App\Player\Application\UseCases\Contracts\PlayerRepository;
use App\Pokedex\Application\UseCases\Contracts\PokemonRepository;
use App\Pokedex\Application\UseCases\Contracts\PokedexRepository;
use App\Shared\Exceptions\AppValidationException;

final class StartBattle
{
    private PlayerRepository $playerRepository;
    private BattleRepository $battleRepository;
    private PokemonRepository $pokemonRepository;
    private StartBattleValidator $validator;
    private PokedexRepository $pokedexRepository;

    public function __construct(
        BattleRepository $battleRepository,
        PlayerRepository $playerRepository,
        PokemonRepository $pokemonRepository,
        PokedexRepository $pokedexRepository,
        StartBattleValidator $validator
    ) {
        $this->playerRepository = $playerRepository;
        $this->battleRepository = $battleRepository;
        $this->pokemonRepository = $pokemonRepository;
        $this->validator = $validator;
        $this->pokedexRepository = $pokedexRepository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $errors = $this->validator->validate($input);

        if (count($errors) > 0) {
            throw new AppValidationException($errors, 'Houve um erro ao iniciar batalha.');
        }

        $trainer = $this->playerRepository->get($input->getTrainerId());
        $pokemon = $this->pokemonRepository->getByAlias($input->getTrainerPokemonAlias());

        $challenger = ($input->getChallengerId() ? $this->playerRepository->get($input->getChallengerId()) : null);
        $pokemonChallenger = $this->pokemonRepository->getByAlias($input->getChallengerPokemonAlias());

        $this->pokedexRepository->markPokemonAsSeen($trainer, $pokemon);
        $this->pokedexRepository->markPokemonAsSeen($trainer, $pokemonChallenger);

        $battle = $this->battleRepository->start(
            new BattlePokemon($pokemon, $trainer),
            new BattlePokemon($pokemonChallenger, $challenger)
        );

        return OutputBoundary::build(['battle' => $battle->toArray()]);
    }
}