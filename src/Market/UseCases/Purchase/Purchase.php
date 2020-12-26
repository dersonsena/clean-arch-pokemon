<?php

namespace App\Market\UseCases\Purchase;

use App\Market\Domain\Contracts\FindItemByPKRepository;
use App\Market\Domain\Exceptions\MarketItemNotFoundException;
use App\Player\Domain\Contracts\AddItemsIntoBagRepository;
use App\Player\Domain\Exceptions\AddItemToBagException;
use App\Player\Domain\Exceptions\DebitMoneyException;
use App\Player\Domain\Factory\BagItemFactory;
use App\Market\Domain\Contracts\CreatePurchaseRepository;
use App\Market\Domain\Exceptions\CreatePurchaseException;
use App\Market\Domain\Exceptions\InsufficientMoneyException;
use App\Market\Domain\Factory\CartFactory;
use App\Player\Domain\Contracts\DebitMoneyRepository;
use App\Player\Domain\Contracts\FindPlayerByPKRepository;
use App\Player\Domain\Exceptions\PlayerNotFoundException;

final class Purchase
{
    private CreatePurchaseRepository $createPurchaseRepository;
    private AddItemsIntoBagRepository $addItemsIntoBagRepository;
    private FindPlayerByPKRepository $findPlayerByPKRepository;
    private DebitMoneyRepository $debitMoneyRepository;
    private FindItemByPKRepository $findItemByPkRepository;

    public function __construct(
        CreatePurchaseRepository $createPurchaseRepository,
        AddItemsIntoBagRepository $addItemsIntoBagRepository,
        FindPlayerByPKRepository $findPlayerByPKRepository,
        DebitMoneyRepository $debitMoneyRepository,
        FindItemByPKRepository $findItemByPkRepository
    ) {
        $this->createPurchaseRepository = $createPurchaseRepository;
        $this->addItemsIntoBagRepository = $addItemsIntoBagRepository;
        $this->findPlayerByPKRepository = $findPlayerByPKRepository;
        $this->debitMoneyRepository = $debitMoneyRepository;
        $this->findItemByPkRepository = $findItemByPkRepository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $player = $this->findPlayerByPKRepository->get((int)$input->getPlayerId());

        if (!$player) {
            throw new PlayerNotFoundException();
        }

        $cart = CartFactory::create();

        foreach ($input->getItems() as $item) {
            $marketItem = $this->findItemByPkRepository->get($item['id']);

            if (!$marketItem) {
                throw new MarketItemNotFoundException();
            }

            $cart->addItem($marketItem);
            $player->getBag()->addItem(BagItemFactory::create($marketItem->toArray()));
        }

        if (!$player->hasSufficientMoneyToPurchase($cart->getTotal())) {
            throw new InsufficientMoneyException();
        }

        if (!$this->createPurchaseRepository->create($cart)) {
            throw new CreatePurchaseException($cart);
        }

        if (!$this->debitMoneyRepository->debit($player, $cart->getTotal())) {
            throw new DebitMoneyException($cart->getTotal());
        }

        if (!$this->addItemsIntoBagRepository->add($player, $player->getBag()->getItems())) {
            throw new AddItemToBagException();
        }

        return OutputBoundary::build([
            'player' => $player->toArray()
        ]);
    }
}