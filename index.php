<?php
require 'vendor/autoload.php';

$routeConfig = 'src/config/routes.yaml';
$logConfig = 'config/logs.yaml';

$app = new \app\RestFulWeb;

$app->setRouteFromFile($routeConfig);
$app->run();