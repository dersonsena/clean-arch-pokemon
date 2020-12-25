<?php

namespace App\Market\UseCases\Purchase;

use App\Player\Domain\Contracts\AddItemsIntoBagRepository;
use App\Player\Domain\Exceptions\AddItemToBagException;
use App\Player\Domain\Exceptions\DebitMoneyException;
use App\Bag\Domain\Factory\ItemFactory as BagItemFactory;
use App\Market\Domain\Contracts\CreatePurchaseRepository;
use App\Market\Domain\Exceptions\CreatePurchaseException;
use App\Market\Domain\Exceptions\InsufficientMoneyException;
use App\Market\Domain\Factory\CartFactory;
use App\Market\Domain\Factory\ItemFactory;
use App\Player\Domain\Contracts\DebitMoneyRepository;
use App\Player\Domain\Contracts\FindPlayerByPKRepository;
use App\Player\Domain\Exceptions\PlayerNotFoundException;

final class Purchase
{
    private CreatePurchaseRepository $createPurchaseRepository;
    private AddItemsIntoBagRepository $addItemsIntoBagRepository;
    private FindPlayerByPKRepository $findByPKRepository;
    private DebitMoneyRepository $debitMoneyRepository;

    public function __construct(
        CreatePurchaseRepository $createPurchaseRepository,
        AddItemsIntoBagRepository $addItemsIntoBagRepository,
        FindPlayerByPKRepository $findByPKRepository,
        DebitMoneyRepository $debitMoneyRepository
    ) {
        $this->createPurchaseRepository = $createPurchaseRepository;
        $this->addItemsIntoBagRepository = $addItemsIntoBagRepository;
        $this->findByPKRepository = $findByPKRepository;
        $this->debitMoneyRepository = $debitMoneyRepository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $player = $this->findByPKRepository->get((int)$input->getPlayerId());

        if (!$player) {
            throw new PlayerNotFoundException($player);
        }

        $cart = CartFactory::create();

        foreach ($input->getItems() as $item) {
            // @todo verify if item exists
            $cart->addItem(ItemFactory::create($item));
            $player->getBag()->addItem(BagItemFactory::create($item));
        }

        if ($player->hasSufficientMoneyToPurchase($cart->getTotal())) {
            throw new InsufficientMoneyException();
        }

        if (!$this->createPurchaseRepository->create($cart)) {
            throw new CreatePurchaseException($cart);
        }

        if (!$this->debitMoneyRepository->debit($cart->getTotal())) {
            throw new DebitMoneyException($cart->getTotal());
        }

        if (!$this->addItemsIntoBagRepository->add($player)) {
            throw new AddItemToBagException();
        }

        return OutputBoundary::build([
            'player' => $player
        ]);
    }
}