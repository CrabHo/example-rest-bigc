<?php
namespace bigc\rest\profile\edu;

use \bigc\resume\model\Education as EduModel;
use \bigc\rest\BaseRest;

class Education extends BaseRest
{
    private $modelEdu;

    public function __construct()
    {
        //Call parent construct
        call_user_func_array('parent::__construct', func_get_args());

        $this->modelEdu = new EduModel;
    }

    public function doGet()
    {
        $res = $this->modelEdu->getData(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('eduid')
        );
        return $this->doSend($res);
    }

    public function doPost()
    {
        $res = $this->modelEdu->addData(
            $this->request->getAttribute('uid'),
            $this->request->getParams()
        );
        return $this->doSend($res);
    }

    public function doPut()
    {
        $res = $this->modelEdu->updateData(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('eduid'),
            $this->request->getParams()
        );
        return $this->doSend($res);
    }

    public function doDelete()
    {
        $res = $this->modelEdu->deleteData(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('eduid')
        );
        return $this->doSend($res);
    }
}
