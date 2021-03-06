<?php

declare(strict_types=1);

namespace App\Pokedex\Adapters\Repository;

use App\Player\Domain\Player;
use App\Pokedex\Domain\Exceptions\PokedexNotFoundException;
use App\Pokedex\Domain\Factory\PokedexFactory;
use App\Pokedex\Domain\Factory\PokemonFactory;
use App\Pokedex\Domain\Pokedex;
use App\Pokedex\Domain\Pokemon;
use App\Pokedex\UseCases\Contracts\PokedexRepository as PokedexRepositoryInterface;
use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\UpdateStatement;

class PokedexRepository implements PokedexRepositoryInterface
{
    private DatabaseDriver $connection;
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;
    private UpdateStatement $updateStatement;

    public function __construct(
        DatabaseDriver $connection,
        SelectStatement $selectStatement,
        InsertStatement $insertStatement,
        UpdateStatement $updateStatement
    ) {
        $this->connection = $connection;
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
        $this->updateStatement = $updateStatement;
    }

    public function markPokemonAsSeen(Player $player, Pokemon $pokemon)
    {
        $pokedex = $this->getPlayerPokedex($player);

        if (is_null($pokedex)) {
            throw new PokedexNotFoundException(['player_id' => $player->getId()]);
        }

        $pokemonToSeen = $this->getPokemonFromPokedex($pokedex, $pokemon);

        if (!is_null($pokemonToSeen)) {
            return;
        }

        $this->insertStatement
            ->into('pokedex_pokemons')
            ->values([
                'pokedex_id' => $pokedex->getId(),
                'pokemon_id' => $pokemon->getId()
            ])
            ->insert();
    }

    public function markPokemonAsCaptured(Player $player, Pokemon $pokemon)
    {
        $pokedex = $this->getPlayerPokedex($player);

        if (is_null($pokedex)) {
            throw new PokedexNotFoundException(['player_id' => $player->getId()]);
        }

        $pokemonToCapture = $this->getPokemonFromPokedex($pokedex, $pokemon);

        if (!is_null($pokemonToCapture)) {
            $this->updateStatement
                ->table('pokedex_pokemons')
                ->values(['captured' => true])
                ->conditions(['id' => $pokemonToCapture->getId()])
                ->update();
        }

        $this->insertStatement
            ->into('pokedex_pokemons')
            ->values([
                'pokedex_id' => $pokedex->getId(),
                'pokemon_id' => $pokemon->getId(),
                'captured' => true
            ])
            ->insert();
    }

    public function getPlayerPokedex(Player $player): ?Pokedex
    {
        $record = $this->selectStatement
            ->select()
            ->from('pokedex')
            ->where('player_id', $player->getId())
            ->fetchOne();

        return PokedexFactory::create($record);
    }

    private function getPokemonFromPokedex(Pokedex $pokedex, Pokemon $pokemon): ?Pokemon
    {
        $record = $this->selectStatement
            ->select()
            ->from('pokedex_pokemons')
            ->where('pokedex_id', $pokedex->getId())
            ->andWhere('pokemon_id', $pokemon->getId())
            ->fetchOne();

        if (is_null($record)) {
            return null;
        }

        return PokemonFactory::create($record);
    }
}
