<?php

declare(strict_types=1);

namespace App\Battle\Adapters\Http;

use App\Battle\Application\UseCases\StartBattle\InputBoundary;
use App\Battle\Application\UseCases\StartBattle\StartBattle;
use App\Shared\Adapters\Http\PayloadAction;

class StartAction extends PayloadAction
{
    private StartBattle $useCase;

    public function __construct(StartBattle $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $input = InputBoundary::build([
            'trainerId' => (int)$this->body['trainer']['id'],
            'trainerPokemonAlias' => $this->body['trainer']['pokemon_alias'],
            'challengerId' => $this->body['challenger']['id'] ?? (int)$this->body['challenger']['id'],
            'challengerPokemonAlias' => $this->body['challenger']['pokemon_alias']
        ]);

        return $this->useCase
            ->handle($input)
            ->toArray()['battle'];
    }
}