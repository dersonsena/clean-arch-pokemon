<?php

use App\Battle\UseCases\Contracts\BattleRepository as BattleRepositoryInterface;
use App\Battle\Infra\Repositories\BattleRepository;
use App\Market\Infra\Repository\MarketRepository;
use App\Market\UseCases\Contracts\MarketRepository as MarketRepositoryRepositoryInterface;
use App\Player\Infra\Repository\PlayerRepository;
use App\Player\UseCases\Contracts\PlayerRepository as PlayerRepositoryRepositoryInterface;
use App\Pokemon\Infra\Repository\PokemonRepository;
use App\Pokemon\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Shared\Contracts\DatabaseConnection;
use App\Shared\Contracts\HttpClient;
use App\Shared\Infra\Adapters\Database\MySQLConnection;
use App\Shared\Infra\Adapters\GuzzleHttpClient;
use DI\Container;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Adapters
    HttpClient::class => DI\autowire(GuzzleHttpClient::class),

    // Repositories
    PlayerRepositoryRepositoryInterface::class => DI\autowire(PlayerRepository::class),
    MarketRepositoryRepositoryInterface::class => DI\autowire(MarketRepository::class),
    BattleRepositoryInterface::class => DI\autowire(BattleRepository::class),
    PokemonRepositoryInterface::class => DI\autowire(PokemonRepository::class),
    DatabaseConnection::class => DI\get('database')
]);

$container = $containerBuilder->build();

$container->set('config', function() {
    return require __DIR__ . DS . 'config.php';
});

$container->set('database', function(Container $container) {
    $dbConfig = $container->get('config')['database'];
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";

    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    return new MySQLConnection($pdo);
});