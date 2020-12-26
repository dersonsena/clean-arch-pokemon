<?php

declare(strict_types=1);

namespace App\Player\UseCases\Contracts;

interface PlayerRepository extends
    AddItemsIntoBagRepository,
    FindPlayerByPKRepository,
    DebitMoneyRepository
{}