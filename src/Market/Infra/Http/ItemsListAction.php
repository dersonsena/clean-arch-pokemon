<?php

declare(strict_types=1);

namespace App\Market\Infra\Http;

use App\Market\Application\UseCases\Contracts\MarketRepository;
use App\Shared\Infra\Http\ActionBase;

class ItemsListAction extends ActionBase
{
    private MarketRepository $marketRepository;

    public function __construct(MarketRepository $marketRepository)
    {
        $this->marketRepository = $marketRepository;
    }

    protected function handle(): array
    {
        return $this->marketRepository->getMarketItems([]);
    }
}