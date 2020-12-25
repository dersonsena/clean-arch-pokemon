<?php

declare(strict_types=1);

namespace App\Player\Domain\Exceptions;

use App\Player\Domain\Player;
use Exception;
use Throwable;

class PlayerNotFoundException extends Exception
{
    public function __construct(Player $player, $message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message ?? sprintf("Jogador com ID %s não foi encontrado", $player->getId());

        parent::__construct($message, $code, $previous);
    }
}