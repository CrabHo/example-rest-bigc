<?php
namespace bigc\rest;

class BaseRest {
    private static $notFoundApi = ['message' => 'API not found'];
    
    protected static $contentType = 'application/json';
    protected $request;
    protected $response;

    public function __construct($req, $res)
    {
        $this->request = $req;
        $this->response = $res;
    }
    public function doPost()
    {
        return $this->doSend(self::$notFoundApi, 404);
    }

    public function doGet()
    {
        return $this->doSend( self::$notFoundApi, 404);
    }

    public function doDelete()
    {
        return $this->doSend( self::$notFoundApi, 404);
    }

    public function doPut()
    {
        return $this->doSend( self::$notFoundApi, 404);
    }

    protected function doSend($responseData, $statusCode = 200)
    {
        return $this->response->withStatus($statusCode)
            ->withHeader('Content-Type', self::$contentType)
            ->write(json_encode($responseData));
    }
}
