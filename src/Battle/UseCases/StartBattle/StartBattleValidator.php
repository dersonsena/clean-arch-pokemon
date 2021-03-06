<?php

declare(strict_types=1);

namespace App\Battle\UseCases\StartBattle;

use App\Shared\Application\ValidationErrorEnum;
use App\Shared\Infra\Gateways\Contracts\ValidatorTool;

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
            $errors['trainer_id'][] = ValidationErrorEnum::REQUIRED;
        }

        if ($this->v->validate($input->getTrainerPokemonAlias(), ValidatorTool::IS_NULL)) {
            $errors['trainer_pokemon_name'][] = ValidationErrorEnum::REQUIRED;
        }

        if (!$this->v->validate($input->getTrainerPokemonAlias(), ValidatorTool::STR_LENGTH, ['min' => 3])) {
            $errors['trainer_pokemon_name'][] = ValidationErrorEnum::MIN_LENGTH . ':3';
        }

        if ($this->v->validate($input->getChallengerPokemonAlias(), ValidatorTool::IS_NULL)) {
            $errors['challenger_pokemon_name'][] = ValidationErrorEnum::REQUIRED;
        }

        if (!$this->v->validate($input->getChallengerPokemonAlias(), ValidatorTool::STR_LENGTH, ['min' => 3])) {
            $errors['challenger_trainer_pokemon_name'][] = ValidationErrorEnum::MIN_LENGTH . ':3';
        }

        return $errors;
    }
}
