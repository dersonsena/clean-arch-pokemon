<?php

declare(strict_types=1);

namespace App\Pokedex\Adapters\Http;

use App\Pokedex\UseCases\Contracts\PokemonRepository;
use App\Shared\Adapters\Http\PayloadAction;

final class SearchAction extends PayloadAction
{
    private PokemonRepository $repository;

    public function __construct(PokemonRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function handle(): array
    {
        return $this->repository->search($this->body);
    }
}
