<?php

declare(strict_types=1);

namespace App\Pokemon\Application\UseCases\Contracts;

use App\Pokemon\Domain\Type;

interface TypeRepository
{
    public function findTypeByName(string $name): ?Type;
    public function createType(Type $type): Type;
    public function get(int $pk): ?Type;
}