<?php
namespace app;

use bigc\rest\FakeRestFulServer;


class VersionTest extends FakeRestFulServer
{
    public function testGetEdus()
    {
        $this->request('get', '/version');
        $this->assertEquals('200', $this->response->getStatusCode());
    }
}