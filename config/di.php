<?php

use DI\Container;
use Slim\Factory\AppFactory;

$container = new Container();

/*$container->set('dependency-name', function (Container $container) {
    return anything
});*/

AppFactory::setContainer($container);