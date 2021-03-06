<?php

declare(strict_types=1);

namespace App\Battle\Infra\Repositories;

use App\Battle\Domain\Battle;
use App\Battle\Domain\Factory\BattleFactory;
use App\Battle\Domain\ValueObjects\BattlePokemon;
use App\Battle\Domain\ValueObjects\BattleStatus;
use App\Battle\UseCases\Contracts\BattleRepository as BattleRepositoryRepository;
use App\Player\UseCases\Contracts\PlayerRepository;
use App\Pokedex\UseCases\Contracts\PokemonRepository;
use App\Shared\Infra\Gateways\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Infra\Gateways\Contracts\QueryBuilder\SelectStatement;
use DateTimeImmutable;

class BattleRepository implements BattleRepositoryRepository
{
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;
    private PlayerRepository $playerRepository;
    private PokemonRepository $pokemonRepository;

    public function __construct(
        SelectStatement $selectStatement,
        InsertStatement $insertStatement,
        PlayerRepository $playerRepository,
        PokemonRepository $pokemonRepository
    ) {
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
        $this->playerRepository = $playerRepository;
        $this->pokemonRepository = $pokemonRepository;
    }

    public function start(BattlePokemon $trainer, BattlePokemon $challenger): Battle
    {
        $record = $this->selectStatement
            ->select()
            ->from('battles')
            ->where('player1_id', $trainer->getTrainer()->getId())
            ->fetchOne();

        if (!is_null($record)) {
            $record['trainer1'] = new BattlePokemon(
                $this->pokemonRepository->get((int)$record['pokemon1_id']),
                $this->playerRepository->get((int)$record['player1_id'])
            );

            $battleChallenger = $record['player2_id'] ? $this->playerRepository->get((int)$record['player2_id']) : null;

            $record['trainer2'] = new BattlePokemon(
                $this->pokemonRepository->get((int)$record['pokemon2_id']),
                $battleChallenger
            );

            return BattleFactory::create($record);
        }

        $battleId = $this->insertStatement
            ->into('battles')
            ->values([
                'player1_id' => $trainer->getTrainer()->getId(),
                'pokemon1_id' => $trainer->getPokemon()->getId(),
                'player2_id' => $challenger->getTrainer() ? $challenger->getTrainer()->getId() : null,
                'pokemon2_id' => $challenger->getPokemon()->getId(),
                'status' => BattleStatus::STARTED,
                'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s')
            ])
            ->insert();

        return BattleFactory::create([
            'id' => $battleId,
            'trainer1' => $trainer,
            'trainer2' => $challenger,
            'status' => BattleStatus::STARTED
        ]);
    }
}
