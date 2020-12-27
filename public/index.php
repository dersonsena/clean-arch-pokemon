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
defined('APP_ENV') or define('APP_ENV', getenv('APP_ENV'));

require_once __DIR__  . '/../config/di.php';

$app = AppFactory::createFromContainer($container);

require __DIR__ . '/../config/errors.php';
require __DIR__ . '/../routes/routes.php';

$app->run();