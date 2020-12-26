<?php

use App\Market\Domain\Contracts\CreatePurchaseRepository as CreatePurchaseRepositoryInterface;
use App\Market\Domain\Contracts\FindItemByPKRepository as FindItemByPKRepositoryAliasInterface;
use App\Market\Infra\Repository\FindItemByPKRepository;
use App\Player\Domain\Contracts\AddItemsIntoBagRepository as AddItemsIntoBagRepositoryInterface;
use App\Player\Domain\Contracts\DebitMoneyRepository as DebitMoneyRepositoryAliasInterface;
use App\Player\Domain\Contracts\FindPlayerByPKRepository as FindPlayerByPKRepositoryAlias;
use App\Market\Infra\Repository\CreatePurchaseRepository;
use App\Player\Infra\Repository\AddItemsIntoBagRepository;
use App\Player\Infra\Repository\DebitMoneyRepository;
use App\Player\Infra\Repository\FindPlayerByPKRepository;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Repositories
    CreatePurchaseRepositoryInterface::class => DI\create(CreatePurchaseRepository::class),
    AddItemsIntoBagRepositoryInterface::class => DI\create(AddItemsIntoBagRepository::class),
    FindPlayerByPKRepositoryAlias::class => DI\create(FindPlayerByPKRepository::class),
    DebitMoneyRepositoryAliasInterface::class => DI\create(DebitMoneyRepository::class),
    FindItemByPKRepositoryAliasInterface::class => DI\create(FindItemByPKRepository::class)
]);

$container = $containerBuilder->build();

AppFactory::setContainer($container);