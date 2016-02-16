<?php
namespace app;

use Symfony\Component\Yaml\Yaml as YamlParser;
use Slim\App as SlimApp;
use Slim\Container as SlimContainer;

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
                $res = ['error' =>
                    [
                        'code'     =>  $exception->getCode(),
                        'message'  =>  get_class($exception) . ':' . $exception->getMessage()
                    ]
                ];
                return $c['response']->withStatus(500)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($res));
            };
        };
    }

    public function setNotFoundHandler()
    {
        $c = $this->slimContainer;
        $c['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                $res = ['error' =>
                    [
                        'code'     =>  -32601,
                        'message'  =>  'Method not found'
                    ]
                ];
                return $c['response']->withStatus(404)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($res));
            };
        };
    }

    public function setNotAllowedHandler()
    {
        $c = $this->slimContainer;
        $c['notAllowedHandler'] = function ($c) {
            return function ($request, $response, $methods) use ($c) {
                $res = ['error' =>
                    [
                        'code'     =>  -32601,
                        'message'  =>  'Method not found'
                    ]
                ];
                return $c['response']->withStatus(405)
                    ->withHeader('Allow', implode(', ', $methods))
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($res));
            };
        };
    }
}