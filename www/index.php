<?php
require __DIR__ . '/../vendor/autoload.php';

$routeConfig = __DIR__ . '/../src/config/routes.yaml';
$logConfig = __DIR__ . '/../src/config/logs.yaml';

$app = new \app\RestFulWeb;

$app->setRouteFromFile($routeConfig);
$app->setLogFromFile($logConfig);
$app->run();
