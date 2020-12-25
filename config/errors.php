<?php
/** @var \Slim\App $app */

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
//$errorMiddleware->setDefaultErrorHandler(new ErrorHandlerMiddleware($app->getCallableResolver(), $app->getResponseFactory()));
