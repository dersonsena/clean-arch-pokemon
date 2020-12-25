<?php

namespace App\Market\UseCases\Purchase;

use App\Market\Domain\Contracts\CreatePurchaseRepository;
use App\Market\Domain\Exceptions\CreatePurchaseException;
use App\Market\Domain\Factory\CartFactory;
use App\Market\Domain\Factory\ItemFactory;

final class Purchase
{
    private CreatePurchaseRepository $createPurchaseRepository;

    public function __construct(CreatePurchaseRepository $createPurchaseRepository)
    {
        $this->createPurchaseRepository = $createPurchaseRepository;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $cart = CartFactory::create();

        foreach ($input->getItems() as $item) {
            // @todo verify if item exists
            $cart->addItem(ItemFactory::create($item));
        }

        if (!$this->createPurchaseRepository->create($cart)) {
            throw new CreatePurchaseException($cart);
        }

        return OutputBoundary::build([
            'count' => $cart->getCount()
        ]);
    }
}