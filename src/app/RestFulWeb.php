<?php
namespace app;

use Symfony\Component\Yaml\Yaml as YamlParser;
use Slim\App as SlimApp;
use Slim\Container as SlimContainer;
use Cascade\Cascade;

class RestFulWeb
{
    private $slimApp;
    private $slimContainer;

    public function __construct()
    {
        $this->slimContainer = new \Slim\Container();
        $this->setErrorHandler();
        $this->setNotFoundHandler();
        $this->setNotAllowedHandler();
        
        $this->slimApp = new SlimApp($this->slimContainer);
    }
    
    public function getApp()
    {
        return $this->slimApp;
    }
    
    public function setLogFromFile($file)
    {
        Cascade::fileConfig($file);
    }
    
    public function setRouteFromFile($file)
    {
        $routeConfig = YamlParser::parse(file_get_contents($file));
        foreach($routeConfig as $key)
        {
            $this->setRoute(
                $key['method'],
                $key['path'],
                $key['class']
            );
        }
    }

    private function setRoute($method, $path, $class)
    {
        $this->slimApp->map(
            $method,
            $path,
            function ($request, $response) use ($class)
            {
                $ref = new $class($request, $response);
                return $ref->process();
            }
        );
    }

    private function yamlParser($file)
    {
        return YamlParser::parse(file_get_contents($file));
    }

    public function run()
    {
        $this->slimApp->run();
    }

    public function setErrorHandler()
    {
        $c = $this->slimContainer;
        $c['errorHandler'] = function ($c) {
            return function ($request, $response, $exception) use ($c) {
                Cascade::getLogger('app')->error("Got exception, $exception");
                $res = ['error' =>
                    [
                        'code'     =>  $exception->getCode(),
                        'message'  =>  get_class($exception) . ':' . $exception->getMessage()
                    ]
                ];
                return $c['response']->withJson($res, 500);
            };
        };
    }

    public function setNotFoundHandler()
    {
        $c = $this->slimContainer;
        $c['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                Cascade::getLogger('app')->error("Url not found " . $request->getUri());
                $res = ['error' =>
                    [
                        'code'     =>  -32601,
                        'message'  =>  'Method not found'
                    ]
                ];
                return $c['response']->withJson($res, 404);
            };
        };
    }

    public function setNotAllowedHandler()
    {
        $c = $this->slimContainer;
        $c['notAllowedHandler'] = function ($c) {
            return function ($request, $response, $methods) use ($c) {
                Cascade::getLogger('app')->error("Method not allow. $methods, " . $request->getUri());
                $res = ['error' =>
                    [
                        'code'     =>  -32601,
                        'message'  =>  'Method not found'
                    ]
                ];
                
                return $c['response']
                    ->withHeader('Allow', implode(', ', $methods))
                    ->withJson($res, 405);
            };
        };
    }
}