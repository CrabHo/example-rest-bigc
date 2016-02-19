<?php
namespace bigc\rest;

use Slim\Http\Body;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;
use Slim\Route;

class FakeRestFulServer extends \PHPUnit_Framework_TestCase
{
    public function request($method, $path)
    {
        $routeConfig = __DIR__ . '/../../src/config/routes.yaml';
        $app = new \app\RestFulWeb;
        $app->setRouteFromFile($routeConfig);
        $app->setLogFromFile(__DIR__ . '/logs.yaml');
        
        $env = Environment::mock();
        $uri = Uri::createFromString('https://slim.dev' . $path);
        $headers = new Headers();
        $cookies = [];
        $serverParams = $env->all();
        $body = new Body(fopen('php://temp', 'r+'));
        $request = new Request('GET', $uri, $headers, $cookies, $serverParams, $body);
        $this->response = new Response;
        $this->response = $app->getApp()->__invoke($request, new Response);
    }
}