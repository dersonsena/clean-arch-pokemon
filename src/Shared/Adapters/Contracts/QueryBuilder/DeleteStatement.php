<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Contracts\QueryBuilder;

interface DeleteStatement extends QueryStatement
{
    public function table(string $tableName): DeleteStatement;
    public function conditions(array $conditions): DeleteStatement;
    public function delete();
}
