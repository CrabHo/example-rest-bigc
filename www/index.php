<?php
require '../vendor/autoload.php';

$routeConfig = '../src/config/routes.yaml';
$logConfig = '../src/config/logs.yaml';

$app = new \app\RestFulWeb;

$app->setRouteFromFile($routeConfig);
$app->setLogFromFile($logConfig);
$app->run();
