<?php

declare(strict_types=1);

namespace App\Market\Adapters\Http;

use App\Market\UseCases\Contracts\MarketRepository;
use App\Shared\Adapters\Http\PayloadAction;

class ItemsListAction extends PayloadAction
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
