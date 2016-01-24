<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';

$app = new \Slim\App;

$app->get('/profile/{id}', function (Request $request, Response $response) {
    $tmp = new \bigc\rest\profile\Basic($request, $response);
    $res = $tmp->doGet();
    return $res;
});

$app->post('/profile', function (Request $request, Response $response) {
    $tmp = new \bigc\rest\profile\Basic($request, $response);
    $res = $tmp->doPost();
    return $res;
});

$app->put('/profile/{id}', function (Request $request, Response $response) {
    $tmp = new \bigc\rest\profile\Basic($request, $response);
    $res = $tmp->doPut();
    return $res;
});

$app->delete('/profile/{id}', function (Request $request, Response $response) {
    $tmp = new \bigc\rest\profile\Basic($request, $response);
    $res = $tmp->doDelete();
    return $res;
});

$c = $app->getContainer();
$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $res = array('error' =>
            array(
                'code'     =>  $exception->getCode(),
                'message'  =>  get_class($exception) . ':' . $exception->getMessage()
            )
        );
        return $c['response']->withStatus(500)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($res));
    };
};

$app->run();
