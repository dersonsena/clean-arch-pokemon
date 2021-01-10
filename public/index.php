<?php
/** @var \DI\Container $container */

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Load application environment from .env file
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('APP_ENV') or define('APP_ENV', $_ENV['APP_ENV']);
defined('APP_DEBUG_ENABLED') or define('APP_DEBUG_ENABLED', (bool)$_ENV['APP_DEBUG_ENABLED']);
defined('CACHE_ENABLE') or define('CACHE_ENABLE', isset($_GET['cache']) ? (bool)$_GET['cache'] : true);

require_once __DIR__  . '/../config/di.php';

$app = AppFactory::createFromContainer($container);

require __DIR__ . '/../config/errors.php';
require __DIR__ . '/../config/routes.php';

$app->run();