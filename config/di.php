<?php

use App\Battle\Application\UseCases\Contracts\BattleRepository as BattleRepositoryInterface;
use App\Battle\Infra\Repositories\BattleRepository;
use App\Market\Infra\Repository\MarketRepository;
use App\Market\Application\UseCases\Contracts\MarketRepository as MarketRepositoryRepositoryInterface;
use App\Player\Infra\Repository\PlayerRepository;
use App\Player\Application\UseCases\Contracts\PlayerRepository as PlayerRepositoryRepositoryInterface;
use App\Pokemon\Infra\Repository\PokemonRepository;
use App\Pokemon\Infra\Repository\TypeRepository;
use App\Pokemon\Application\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Pokemon\Application\UseCases\Contracts\TypeRepository as TypeRepositoryInterface;
use App\Shared\Contracts\CacheSystem;
use App\Shared\Contracts\DatabaseConnection;
use App\Shared\Contracts\HttpClient;
use App\Shared\Contracts\PokemonAPI;
use App\Shared\Contracts\ValidatorTool;
use App\Shared\Infra\Adapters\Database\MySQLConnection;
use App\Shared\Infra\Adapters\GuzzleHttpClient;
use App\Shared\Infra\Adapters\PokeAPI;
use App\Shared\Infra\Adapters\PRedisClient;
use App\Shared\Infra\Adapters\RespectValidation;
use DI\Container;
use DI\ContainerBuilder;
use Predis\Client;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Adapters
    HttpClient::class => DI\autowire(GuzzleHttpClient::class),
    DatabaseConnection::class => DI\get('database'),
    CacheSystem::class => DI\get('cache'),
    PokemonAPI::class => DI\get('pokemonApi'),
    ValidatorTool::class => DI\autowire(RespectValidation::class),

    // Repositories
    PlayerRepositoryRepositoryInterface::class => DI\autowire(PlayerRepository::class),
    MarketRepositoryRepositoryInterface::class => DI\autowire(MarketRepository::class),
    BattleRepositoryInterface::class => DI\autowire(BattleRepository::class),
    PokemonRepositoryInterface::class => DI\autowire(PokemonRepository::class),
    TypeRepositoryInterface::class => DI\autowire(TypeRepository::class)
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
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => TRUE
    ]);

    return new MySQLConnection($pdo);
});

$container->set('cache', function(Container $container) {
    $cacheConfig = $container->get('config')['cache'];

    $predis = new Client("redis://{$cacheConfig['host']}:{$cacheConfig['port']}");
    $predis->auth($cacheConfig['password']);

    return new PRedisClient($predis, $container->get('config')['cache']['params']);
});

$container->set('pokemonApi', function(Container $container) {
    $pokeApiConfig = $container->get('config')['externalApi']['pokeapi'];

    return new PokeAPI($container->get(HttpClient::class), $pokeApiConfig);
});