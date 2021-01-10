<?php
/** @var \Slim\App $app */

use App\Battle\Infra\Http\StartAction;
use App\Market\Infra\Http\ItemsListAction;
use App\Market\Infra\Http\PurchaseAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

$app->group('/market', function (RouteCollectorProxyInterface $group) {
    $group->post('/purchase', PurchaseAction::class);
    $group->get('/items', ItemsListAction::class);
});

$app->group('/battle', function (RouteCollectorProxyInterface $group) {
    $group->post('/start', StartAction::class);
});