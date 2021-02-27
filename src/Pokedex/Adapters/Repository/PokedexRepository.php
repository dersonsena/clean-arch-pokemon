<?php

declare(strict_types=1);

namespace App\Pokedex\Adapters\Repository;

use App\Player\Domain\Player;
use App\Pokedex\Domain\Exceptions\PokedexNotFoundException;
use App\Pokedex\Domain\Pokemon;
use App\Pokedex\Application\UseCases\Contracts\PokedexRepository as PokedexRepositoryInterface;
use App\Shared\Adapters\Gateways\Contracts\DatabaseDriver;

class PokedexRepository implements PokedexRepositoryInterface
{
    private DatabaseDriver $connection;

    public function __construct(DatabaseDriver $connection)
    {
        $this->connection = $connection;
    }

    public function markPokemonAsSeen(Player $player, Pokemon $pokemon)
    {
        $pokedex = $this->getPokedexByPk((int)$player->getId());

        if (is_null($pokedex)) {
            throw new PokedexNotFoundException(['player_id' => $player->getId()]);
        }

        $pokemonToSeen = $this->getPokemonFromPokedex((int)$pokedex['id'], $pokemon->getId());

        if (!is_null($pokemonToSeen)) {
            return;
        }

        $this->connection
            ->setTable('pokedex_pokemons')
            ->insert([
                'pokedex_id' => (int)$pokedex['id'],
                'pokemon_id' => $pokemon->getId()
            ]);
    }

    public function markPokemonAsCaptured(Player $player, Pokemon $pokemon)
    {
        $pokedex = $this->getPokedexByPk((int)$player->getId());

        if (is_null($pokedex)) {
            throw new PokedexNotFoundException(['player_id' => $player->getId()]);
        }

        $pokemonSeen = $this->getPokemonFromPokedex((int)$pokedex['id'], $pokemon->getId());

        if (!is_null($pokemonSeen)) {
            $this->connection
                ->setTable('pokedex_pokemons')
                ->update(['captured' => true], ['id' => $pokemonSeen['id']]);
        }

        $this->connection
            ->setTable('pokedex_pokemons')
            ->insert([
                'pokedex_id' => (int)$pokedex['id'],
                'pokemon_id' => $pokemon->getId(),
                'captured' => true
            ]);
    }

    private function getPokedexByPk(int $pk): ?array
    {
        return $this->connection
            ->setTable('pokedex')
            ->select(['conditions' => ['player_id' => $pk]])
            ->fetchOne();
    }

    private function getPokemonFromPokedex(int $pokedexId, int $pokemonId): ?array
    {
        return $pokemonToSeen = $this->connection
            ->setTable('pokedex_pokemons')
            ->select([
                'conditions' => [
                    'pokedex_id' => $pokedexId,
                    'pokemon_id' => $pokemonId
                ]
            ])
            ->fetchOne();
    }
}