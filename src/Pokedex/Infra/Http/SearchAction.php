<?php

declare(strict_types=1);

namespace App\Pokedex\Infra\Http;

use App\Pokedex\UseCases\Contracts\PokemonRepository;
use App\Shared\Infra\Http\PayloadAction;

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
