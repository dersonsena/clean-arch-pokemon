<?php

namespace App\Market\Application\UseCases\Purchase;

use App\Market\Application\UseCases\Contracts\MarketRepository;
use App\Market\Domain\Factory\CartItemFactory;
use App\Player\Application\UseCases\Contracts\PlayerRepository;
use App\Market\Domain\Factory\CartFactory;
use App\Shared\Exceptions\AppValidationException;

final class Purchase
{
    private PlayerRepository $playerRepository;
    private MarketRepository $marketRepository;
    private PurchaseValidator $validator;

    public function __construct(
        PlayerRepository $playerRepository,
        MarketRepository $marketRepository,
        PurchaseValidator $validator
    ) {
        $this->playerRepository = $playerRepository;
        $this->marketRepository = $marketRepository;
        $this->validator = $validator;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $errors = $this->validator->validate($input);

        if (count($errors) > 0) {
            throw new AppValidationException($errors, 'Erro na validação da compra de itens.');
        }

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