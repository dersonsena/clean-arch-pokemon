<?php
/** @var \Slim\App $app */

use App\Battle\Application\StartAction;
use App\Market\Application\PurchaseAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

$app->group('/market', function (RouteCollectorProxyInterface $group) {
    $group->post('/purchase', PurchaseAction::class);
});

$app->group('/battle', function (RouteCollectorProxyInterface $group) {
    $group->post('/start', StartAction::class);
});