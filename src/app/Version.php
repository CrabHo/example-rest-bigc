<?php

namespace app;

class Version extends BaseRest
{
    public function __construct()
    {
        call_user_func_array('parent::__construct', func_get_args());
    }

    public function process()
    {
        switch($this->request->getMethod())
        {
            case 'GET':
                return $this->getVersion();
        }
    }

    public function getVersion()
    {
        return $this->doSend([
            'result' => '1.0.0'
        ]);
    }
}
