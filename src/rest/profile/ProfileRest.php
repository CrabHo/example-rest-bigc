<?php

namespace bigc\rest\profile;

use \bigc\profile\model\Profile;
use \bigc\profile\data\ProfileData;
use \app\BaseRest;

class ProfileRest extends BaseRest
{

    private $model;

    public function __construct()
    {
        //Call parent construct
        call_user_func_array('parent::__construct', func_get_args());

        $this->model = new Profile;
    }

    public function process()
    {
        switch($this->request->getMethod())
        {
            case 'GET':
                if(empty($this->request->getAttribute('id')))
                    return $this->doGets();
                else
                    return $this->doGet();
            case 'PUT':
                return $this->doPut();
            case 'DELETE':
                return $this->doDelete();
            case 'POST':
                return $this->doPost();
        }
    }


    public function doGets()
    {
        $userDatas = $this->model->getDatas();
        $res = [];
        foreach($userDatas as $userData)
        {
            $tmp = [
                'id'    => $userData->getId(),
                'name'  => $userData->getName(),
                'email' => $userData->getEmail(),
                'sex'   => $userData->getSex()
            ];
            array_push($res, $tmp);
        }
        return $this->doSend(['result' => $res]);
    }

    public function doGet()
    {
        $id = $this->request->getAttribute('id');
        $userData = $this->model->getData($id);
        $res = [
            'id'    => $userData->getId(),
            'name'  => $userData->getName(),
            'email' => $userData->getEmail(),
            'sex'   => $userData->getSex()
        ];
        return $this->doSend(['result' => $res]);
    }

    public function doDelete()
    {
        $id = $this->request->getAttribute('id');
        return $this->doSend([
            'result' => $this->model->deleteData($id)
        ]);
    }

    public function doPut()
    {
        $data = ProfileData::makeProfile(
            $this->request->getAttribute('id'),
            $this->request->getParams()['name'],
            $this->request->getParams()['email'],
            $this->request->getParams()['sex']
        );

        return $this->doSend([
            'result' => $this->model->updateData($data)
        ]);
    }


    public function doPost()
    {
        $data = ProfileData::makeProfile(
            null,
            $this->request->getParams()['name'],
            $this->request->getParams()['email'],
            $this->request->getParams()['sex']
        );
        return $this->doSend([
            'result' => $this->model->addData($data)
        ]);
    }
}
