<?php

declare(strict_types=1);

namespace App\Battle\Application;

use App\Battle\UseCases\StartBattle\InputBoundery;
use App\Battle\UseCases\StartBattle\StartBattle;
use App\Shared\Application\ActionBase;

class StartAction extends ActionBase
{
    private StartBattle $useCase;

    public function __construct(StartBattle $useCase)
    {
        $this->useCase = $useCase;
    }

    protected function handle(): array
    {
        $input = InputBoundery::build([
            'trainerId' => (int)$this->body['trainer']['id'],
            'trainerPokemonId' => (int)$this->body['trainer']['pokemon_id'],
            'challengerId' => $this->body['challenger']['id'] ?? (int)$this->body['challenger']['id'],
            'challengerPokemonId' => (int)$this->body['challenger']['pokemon_id'],
        ]);

        return $this->useCase
            ->handle($input)
            ->toArray();
    }
}