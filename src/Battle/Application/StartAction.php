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
            'trainerId' => $this->body['trainer']['id'],
            'trainerPokemonId' => $this->body['trainer']['pokemon_id'],
            'challengerId' => $this->body['challenger']['id'],
            'challengerPokemonId' => $this->body['challenger']['pokemon_id'],
        ]);

        return $this->useCase
            ->handle($input)
            ->toArray();
    }
}