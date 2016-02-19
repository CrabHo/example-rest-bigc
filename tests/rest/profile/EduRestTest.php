<?php
namespace bigc\rest\profile;

use bigc\rest\FakeRestFulServer;


class EduRestTest extends FakeRestFulServer
{
    public function testGetEdus()
    {
        $this->request('get', '/profile');
        $this->assertEquals('200', $this->response->getStatusCode());
    }
}