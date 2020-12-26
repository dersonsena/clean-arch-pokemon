<?php
/** @var \Slim\App $app */

use App\Battle\Application\StartAction;
use App\Market\Application\PurchaseAction;

$app->post('/purchase', PurchaseAction::class);
$app->post('/battle/start', StartAction::class);