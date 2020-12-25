<?php

use Slim\Factory\AppFactory;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__  . '/../config/di.php';

$app = AppFactory::create();

require __DIR__ . '/../config/errors.php';
require __DIR__ . '/../routes/routes.php';

$app->run();