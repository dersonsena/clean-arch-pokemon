<?php

declare(strict_types=1);

namespace App\Player\Adapters\Http;

use App\Player\UseCases\Contracts\PlayerRepository;
use App\Shared\Application\Enum\ValidationErrorEnum;
use App\Shared\Exceptions\AppValidationException;
use App\Shared\Adapters\Http\PayloadAction;

class ProfileAction extends PayloadAction
{
    private PlayerRepository $repository;

    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function handle(): array
    {
        $playerId = $this->args['id'] ?? null;

        if (is_null($playerId)) {
            throw new AppValidationException(['player_id' => ValidationErrorEnum::REQUIRED]);
        }

        if (empty($playerId)) {
            throw new AppValidationException(['player_id' => ValidationErrorEnum::EMPTY]);
        }

        return $this->repository->profileInfo((int)$playerId);
    }
}
