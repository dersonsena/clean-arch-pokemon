<?php

declare(strict_types=1);

namespace App\Battle\Application\UseCases\StartBattle;

use App\Shared\Contracts\ValidatorTool;

final class StartBattleValidator
{
    private ValidatorTool $v;

    public function __construct(ValidatorTool $validatorTool)
    {
        $this->v = $validatorTool;
    }

    public function validate(InputBoundary $input): array
    {
        $errors = [];
        
        if ($this->v->validate($input->getTrainerId(), ValidatorTool::IS_NULL)) {
            $errors['trainer_id'][] = 'required';
        }

        if ($this->v->validate($input->getTrainerPokemonAlias(), ValidatorTool::IS_NULL)) {
            $errors['trainer_pokemon_name'][] = 'required';
        }

        if (!$this->v->validate($input->getTrainerPokemonAlias(), ValidatorTool::STR_LENGTH, ['min' => 3])) {
            $errors['trainer_pokemon_name'][] = 'min-length:3';
        }

        if ($this->v->validate($input->getChallengerPokemonAlias(), ValidatorTool::IS_NULL)) {
            $errors['challenger_pokemon_name'][] = 'required';
        }

        if (!$this->v->validate($input->getChallengerPokemonAlias(), ValidatorTool::STR_LENGTH, ['min' => 3])) {
            $errors['challenger_trainer_pokemon_name'][] = 'min-length:3';
        }

        return $errors;
    }
}