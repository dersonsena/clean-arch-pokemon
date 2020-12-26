<?php

namespace App\Market\UseCases\Purchase;

use App\Market\Domain\Exceptions\MarketItemNotFoundException;
use App\Market\UseCases\Contracts\MarketRepository;
use App\Player\UseCases\Contracts\PlayerRepository;
use App\Player\Domain\Exceptions\AddItemToBagException;
use App\Player\Domain\Exceptions\DebitMoneyException;
use App\Player\Domain\Factory\BagItemFactory;
use App\Market\Domain\Exceptions\CreatePurchaseException;
use App\Market\Domain\Exceptions\InsufficientMoneyException;
use App\Market\Domain\Factory\CartFactory;
use App\Player\Domain\Exceptions\PlayerNotFoundException;

final class Purchase
{
    private PlayerRepository $playerRepository;
    private MarketRepository $marketRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        MarketRepository $marketRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->marketRepository = $marketRepository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $player = $this->playerRepository->get((int)$input->getPlayerId());

        if (!$player) {
            throw new PlayerNotFoundException();
        }

        $cart = CartFactory::create();

        foreach ($input->getItems() as $item) {
            $marketItem = $this->marketRepository->getItem($item['id']);

            if (!$marketItem) {
                throw new MarketItemNotFoundException();
            }

            $cart->addItem($marketItem);
            $player->getBag()->addItem(BagItemFactory::create($marketItem->toArray()));
        }

        if (!$player->hasSufficientMoneyToPurchase($cart->getTotal())) {
            throw new InsufficientMoneyException();
        }

        if (!$this->marketRepository->purchase($cart)) {
            throw new CreatePurchaseException($cart);
        }

        if (!$this->playerRepository->debitMoney($player, $cart->getTotal())) {
            throw new DebitMoneyException($cart->getTotal());
        }

        if (!$this->playerRepository->addIntoBag($player, $player->getBag()->getItems())) {
            throw new AddItemToBagException();
        }

        return OutputBoundary::build([
            'player' => $player->toArray()
        ]);
    }
}