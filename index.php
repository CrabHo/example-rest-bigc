<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';

$app = new \Slim\App;

//Profile API
$app->group('/profile', function () {
    $this->map(['GET', 'PUT', 'DELETE'],'/{id:[0-9]+}',
        function(Request $request, Response $response)
        {
            $profileRest = new \bigc\rest\profile\ProfileRest(
                $request,
                $response
            );
            switch($request->getMethod())
            {
                case 'GET':
                    $res = $profileRest->doGet();
                    break;
                case 'PUT':
                    $res = $profileRest->doPut();
                    break;
                case 'DELETE':
                    $res = $profileRest->doDelete();
                    break;
            }
            //return $res;
        }
    );
    $this->map(['GET', 'POST'],'',
        function(Request $request, Response $response)
        {
            $profileRest = new \bigc\rest\profile\ProfileRest(
                $request,
                $response
            );
            switch($request->getMethod())
            {
                case 'GET':
                    $res = $profileRest->doGets();
                    break;
                case 'POST':
                    $res = $profileRest->doPost();
                    break;
            }
            return $res;
        }
    );
});

//Edu
$app->group('/profile/{uid:[0-9]+}/edu', function () {
    $this->map(['GET', 'PUT', 'DELETE'],'/{eduid:[0-9]+}',
        function(Request $request, Response $response)
        {
            $eduRest = new \bigc\rest\profile\EduRest(
                $request,
                $response
            );
            switch($request->getMethod())
            {
                case 'GET':
                    $res = $eduRest->doGet();
                    break;
                case 'PUT':
                    $res = $eduRest->doPut();
                    break;
                case 'DELETE':
                    $res = $eduRest->doDelete();
                    break;
            }
            //return $res;
        }
    );
    $this->map(['GET', 'POST'],'',
        function(Request $request, Response $response)
        {
            $eduRest = new \bigc\rest\profile\EduRest(
                $request,
                $response
            );
            switch($request->getMethod())
            {
                case 'GET':
                    $res = $eduRest->doGets();
                    break;
                case 'POST':
                    $res = $eduRest->doPost();
                    break;
            }
            return $res;
        }
    );
});

//Exp
$app->group('/profile/{uid:[0-9]+}/exp', function () {
    $this->map(['GET', 'PUT', 'DELETE'],'/{expid:[0-9]+}',
        function(Request $request, Response $response)
        {
            $expRest = new \bigc\rest\profile\ExpRest(
                $request,
                $response
            );
            switch($request->getMethod())
            {
                case 'GET':
                    $res = $expRest->doGet();
                    break;
                case 'PUT':
                    $res = $expRest->doPut();
                    break;
                case 'DELETE':
                    $res = $expRest->doDelete();
                    break;
            }
            //return $res;
        }
    );
    $this->map(['GET', 'POST'],'',
        function(Request $request, Response $response)
        {
            $expRest = new \bigc\rest\profile\ExpRest(
                $request,
                $response
            );
            switch($request->getMethod())
            {
                case 'GET':
                    $res = $expRest->doGets();
                    break;
                case 'POST':
                    $res = $expRest->doPost();
                    break;
            }
            return $res;
        }
    );
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
