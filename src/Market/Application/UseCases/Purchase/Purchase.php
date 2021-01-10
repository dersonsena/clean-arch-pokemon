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
        $cart = CartFactory::create(['player' => $player->toArray()]);

        foreach ($input->getItems() as $item) {
            $marketItem = $this->marketRepository->getMartItem($item['id']);

            $cartItem = CartItemFactory::create(array_merge($item, ['item' => $marketItem->toArray()]));
            $cartItem->setName($marketItem->getName());
            $cartItem->setTotal($cartItem->getPrice() * $cartItem->getQuantity());

            $cart->addItem($cartItem);
        }

        $this->marketRepository->purchase($cart, $player);

        return OutputBoundary::build([
            'player' => $player->toArray()
        ]);
    }
}