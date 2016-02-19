<?php
namespace app;

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

    protected function process()
    {
        return $this->doSend(self::$notFoundApi, 404);
    }

    protected function doSend($responseData, $statusCode = 200)
    {
        return $this->response->withJson($responseData, $statusCode);
    }
}
