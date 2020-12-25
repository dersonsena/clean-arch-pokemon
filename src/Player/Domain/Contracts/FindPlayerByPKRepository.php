<?php

namespace App\Player\Domain\Contracts;

use App\Player\Domain\Player;

interface FindPlayerByPKRepository
{
    /**
     * @param int $pk
     * @return Player|null
     */
    public function get(int $pk): ?Player;
}