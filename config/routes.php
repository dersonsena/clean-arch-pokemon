<?php

/** @var \Slim\App $app */

use App\Battle\Infra\Http\StartAction;
use App\Market\Infra\Http\ItemsListAction;
use App\Market\Infra\Http\PurchaseAction;
use App\Player\Infra\Http\ProfileAction;
use App\Pokedex\Infra\Http\SearchAction;
use Slim\Interfaces\RouteCollectorProxyInterface;

$app->group('/player', function (RouteCollectorProxyInterface $group) {
    $group->get('/profile', ProfileAction::class);
});

$app->group('/pokedex', function (RouteCollectorProxyInterface $group) {
    $group->get('/search', SearchAction::class);
});

$app->group('/market', function (RouteCollectorProxyInterface $group) {
    $group->post('/purchase', PurchaseAction::class);
    $group->get('/items', ItemsListAction::class);
});

$app->group('/battle', function (RouteCollectorProxyInterface $group) {
    $group->post('/start', StartAction::class);
});