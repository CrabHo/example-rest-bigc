<?php
namespace bigc\rest\profile;

use \bigc\profile\model\Basic as BasicModel;
use \bigc\rest\BaseRest;

class Basic extends BaseRest
{
    private $modelBasic;

    public function __construct()
    {
        //Call parent construct
        call_user_func_array('parent::__construct', func_get_args());

        $this->modelBasic = new BasicModel;
    }

    public function doGets()
    {
        $res = $this->modelBasic->getBasicDatas();
        return $this->doSend($res);
    }

    public function doGet()
    {
        $res = $this->modelBasic->getBasicData(
            $this->request->getAttribute('id')
        );
        return $this->doSend($res);
    }

    public function doPost()
    {
        $res = $this->modelBasic->addBasicData($this->request->getParams());
        return $this->doSend($res);
    }

    public function doPut()
    {
        $res = $this->modelBasic->updateBasicData(
            $this->request->getAttribute('id'),
            $this->request->getParams()
        );
        return $this->doSend($res);
    }

    public function doDelete()
    {
        $res = $this->modelBasic->deleteBasicData(
            $this->request->getAttribute('id')
        );
        return $this->doSend($res);
    }
}