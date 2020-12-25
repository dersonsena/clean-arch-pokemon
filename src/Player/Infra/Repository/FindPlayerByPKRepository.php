<?php

declare(strict_types=1);

namespace App\Player\Infra\Repository;

use App\Player\Domain\Contracts\FindPlayerByPKRepository as FindPlayerByPKRepositoryInterface;
use App\Player\Domain\Player;

class FindPlayerByPKRepository implements FindPlayerByPKRepositoryInterface
{
    public function get(int $pk): ?Player
    {
        return null;
    }
}