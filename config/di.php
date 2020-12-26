<?php

use App\Battle\UseCases\Contracts\BattleRepository as BattleRepositoryInterface;
use App\Battle\Infra\Repositories\BattleRepository;
use App\Market\Infra\Repository\MarketRepository;
use App\Market\UseCases\Contracts\MarketRepository as MarketRepositoryRepositoryInterface;
use App\Player\Infra\Repository\PlayerRepository;
use App\Player\UseCases\Contracts\PlayerRepository as PlayerRepositoryRepositoryInterface;
use App\Pokemon\Infra\Repository\PokemonRepository;
use App\Pokemon\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Repositories
    PlayerRepositoryRepositoryInterface::class => DI\create(PlayerRepository::class),
    MarketRepositoryRepositoryInterface::class => DI\create(MarketRepository::class),
    BattleRepositoryInterface::class => DI\create(BattleRepository::class),
    PokemonRepositoryInterface::class => DI\create(PokemonRepository::class)
]);

$container = $containerBuilder->build();

AppFactory::setContainer($container);