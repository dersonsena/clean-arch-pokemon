<?php

namespace App\Market\Application\UseCases\Purchase;

use App\Market\Domain\CartItem;
use App\Market\Domain\Exceptions\MartItemNotFoundException;
use App\Market\Application\UseCases\Contracts\MarketRepository;
use App\Market\Domain\Factory\CartItemFactory;
use App\Player\Application\UseCases\Contracts\PlayerRepository;
use App\Player\Domain\Exceptions\AddItemToBagException;
use App\Player\Domain\Exceptions\DebitMoneyException;
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

        $cart = CartFactory::create(['player' => $player->toArray()]);

        foreach ($input->getItems() as $item) {
            $marketItem = $this->marketRepository->getMartItem($item['id']);

            if (!$marketItem) {
                throw new MartItemNotFoundException($item['id']);
            }

            $cartItem = CartItemFactory::create(array_merge($item, ['item' => $marketItem->toArray()]));
            $cartItem->setName($marketItem->getName());
            $cartItem->setTotal($cartItem->getPrice() * $cartItem->getQuantity());

            $cart->addItem($cartItem);
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

        if (!$this->playerRepository->addIntoBag($player, $cart->getMartItemsList())) {
            throw new AddItemToBagException();
        }

        return OutputBoundary::build([
            'player' => $player->toArray()
        ]);
    }
}