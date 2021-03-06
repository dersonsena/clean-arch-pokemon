<?php

use App\Battle\UseCases\Contracts\BattleRepository as BattleRepositoryInterface;
use App\Battle\Adapters\Repositories\BattleRepository;
use App\Market\Adapters\Repository\MarketRepository;
use App\Market\UseCases\Contracts\MarketRepository as MarketRepositoryRepositoryInterface;
use App\Player\Adapters\Repository\PlayerRepository;
use App\Player\UseCases\Contracts\PlayerRepository as PlayerRepositoryRepositoryInterface;
use App\Pokedex\Adapters\Repository\PokemonRepository;
use App\Pokedex\Adapters\Repository\TypeRepository;
use App\Pokedex\UseCases\Contracts\PokemonRepository as PokemonRepositoryInterface;
use App\Pokedex\UseCases\Contracts\TypeRepository as TypeRepositoryInterface;
use App\Pokedex\UseCases\Contracts\PokedexRepository as PokedexRepositoryInterface;
use App\Pokedex\Adapters\Repository\PokedexRepository;
use App\Shared\Adapters\Gateways\Contracts\CacheSystem;
use App\Shared\Adapters\Gateways\Contracts\DatabaseDriver;
use App\Shared\Adapters\Gateways\Contracts\HttpClient;
use App\Shared\Adapters\Gateways\Contracts\PokemonAPI;
use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\DeleteStatement;
use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Adapters\Gateways\Contracts\QueryBuilder\UpdateStatement;
use App\Shared\Adapters\Gateways\Contracts\ValidatorTool;
use App\Shared\Adapters\Gateways\Drivers\MySQLDriver;
use App\Shared\Adapters\Gateways\GuzzleHttpClient;
use App\Shared\Adapters\Gateways\PokeAPI;
use App\Shared\Adapters\Gateways\PRedisClient;
use App\Shared\Adapters\Gateways\QueryBuilder\MySQL\Delete;
use App\Shared\Adapters\Gateways\QueryBuilder\MySQL\Insert;
use App\Shared\Adapters\Gateways\QueryBuilder\MySQL\Select;
use App\Shared\Adapters\Gateways\QueryBuilder\MySQL\Update;
use App\Shared\Adapters\Gateways\RespectValidation;
use App\Shared\Adapters\Gateways\TwigEngine;
use App\Shared\Adapters\Presentation\Contracts\TemplatePresenter;
use DI\Container;
use DI\ContainerBuilder;
use Predis\Client;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Adapters
    HttpClient::class => DI\autowire(GuzzleHttpClient::class),
    DatabaseDriver::class => DI\get('database'),
    CacheSystem::class => DI\get('cache'),
    PokemonAPI::class => DI\get('pokemonApi'),
    ValidatorTool::class => DI\autowire(RespectValidation::class),
    TemplatePresenter::class => DI\get('templatePresentation'),
    SelectStatement::class => DI\autowire(Select::class),
    InsertStatement::class => DI\autowire(Insert::class),
    UpdateStatement::class => DI\autowire(Update::class),
    DeleteStatement::class => DI\autowire(Delete::class),

    // Repositories
    PlayerRepositoryRepositoryInterface::class => DI\autowire(PlayerRepository::class),
    MarketRepositoryRepositoryInterface::class => DI\autowire(MarketRepository::class),
    BattleRepositoryInterface::class => DI\autowire(BattleRepository::class),
    PokemonRepositoryInterface::class => DI\autowire(PokemonRepository::class),
    TypeRepositoryInterface::class => DI\autowire(TypeRepository::class),
    PokedexRepositoryInterface::class => DI\autowire(PokedexRepository::class)
]);

$container = $containerBuilder->build();

$container->set('config', function() {
    return require __DIR__ . DS . 'config.php';
});

$container->set('database', function(Container $container) {
    $dbConfig = $container->get('config')['database'];

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $dbConfig['host'],
        $dbConfig['port'],
        $dbConfig['dbname'],
        $dbConfig['charset']
    );

    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => TRUE
    ]);

    return new MySQLDriver($pdo);
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

$container->set('templatePresentation', function(Container $container) {
    $config = $container->get('config')['templatePresentation'];

    $loader = new FilesystemLoader($config['viewsPath']);

    $twig = new Environment($loader, [
        'cache' => $config['enableCache'] === true ? $config['cachePath'] : false
    ]);

    return new TwigEngine($twig, $config);
});
