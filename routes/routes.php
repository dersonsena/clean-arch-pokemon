<?php
/** @var \Slim\App $app */

use App\Market\Application\PurchaseAction;

$app->post('/purchase', PurchaseAction::class);