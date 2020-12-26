<?php

declare(strict_types=1);

namespace App\Market\UseCases\Contracts;

interface MarketRepository extends
    CreatePurchaseRepository,
    FindItemByPKRepository
{}