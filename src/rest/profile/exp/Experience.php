<?php
namespace bigc\rest\profile\exp;

use \bigc\resume\model\Experience as ExpModel;
use \bigc\rest\BaseRest;

class Experience extends BaseRest
{
    private $modelExp;

    public function __construct()
    {
        //Call parent construct
        call_user_func_array('parent::__construct', func_get_args());

        $this->modelExp = new ExpModel;
    }

    public function doGets()
    {
        $res = $this->modelExp->getDatas(
            $this->request->getAttribute('uid')
        );
        return $this->doSend($res);
    }

    public function doGet()
    {
        $res = $this->modelExp->getData(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('expid')
        );
        return $this->doSend($res);
    }

    public function doPost()
    {
        $res = $this->modelExp->addData(
            $this->request->getAttribute('uid'),
            $this->request->getParams()
        );
        return $this->doSend($res);
    }

    public function doPut()
    {
        $res = $this->modelExp->updateData(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('expid'),
            $this->request->getParams()
        );
        return $this->doSend($res);
    }

    public function doDelete()
    {
        $res = $this->modelExp->deleteData(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('expid')
        );
        return $this->doSend($res);
    }
}
