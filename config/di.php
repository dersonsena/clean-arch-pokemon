<?php

use App\Battle\UseCases\Contracts\StartBattleRepository as StartBattleRepositoryAliasInterface;
use App\Battle\Infra\Repositories\StartBattleRepository;
use App\Market\Infra\Repository\MarketRepository;
use App\Market\UseCases\Contracts\MarketRepository as MarketRepositoryRepositoryInterface;
use App\Player\Infra\Repository\PlayerRepository;
use App\Player\UseCases\Contracts\PlayerRepository as PlayerRepositoryRepositoryInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Repositories
    PlayerRepositoryRepositoryInterface::class => DI\create(PlayerRepository::class),
    MarketRepositoryRepositoryInterface::class => DI\create(MarketRepository::class),
    StartBattleRepositoryAliasInterface::class => DI\create(StartBattleRepository::class)
]);

$container = $containerBuilder->build();

AppFactory::setContainer($container);