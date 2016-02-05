<?php

namespace bigc\rest\profile;

use \bigc\resume\model\Experience;
use \bigc\resume\data\ExperienceData;
use \bigc\rest\BaseRest;

class ExpRest extends BaseRest
{

    private $model;

    public function __construct()
    {
        //Call parent construct
        call_user_func_array('parent::__construct', func_get_args());

        $this->model = new Experience;
    }
    public function doGets()
    {
        $datas = $this->model->getDatas($this->request->getAttribute('uid'));
        $res = [];
        foreach($datas as $data)
        {
            $tmp = [
                'uid'       => $data->getUid(),
                'expid'     => $data->getExpId(),
                'firmName'  => $data->getFirmName(),
                'indCatNo'  => $data->getIndCatNo(),
                'jobName'   => $data->getJobName(),
                'areaNo'    => $data->getAreaNo()
            ];
            array_push($res, $tmp);
        }
        return $this->doSend(['result' => $res]);
    }

    public function doGet()
    {
        $uid = $this->request->getAttribute('uid');
        $expid = $this->request->getAttribute('expid');
        $data = $this->model->getData($uid, $expid);
        $res = [
            'uid'       => $data->getUid(),
            'expid'     => $data->getExpId(),
            'firmName'  => $data->getFirmName(),
            'indCatNo'  => $data->getIndCatNo(),
            'jobName'   => $data->getJobName(),
            'areaNo'    => $data->getAreaNo()
        ];
        return $this->doSend(['result' => $res]);
    }

    public function doDelete()
    {
        $uid = $this->request->getAttribute('uid');
        $expid = $this->request->getAttribute('expid');
        return $this->doSend([
            'result' => $this->model->deleteData($uid, $expid)
        ]);
    }

    public function doPut()
    {
        $data = ExperienceData::makeExperience(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('expid'),
            $this->request->getParams()['firmName'],
            $this->request->getParams()['indCatNo'],
            $this->request->getParams()['jobName'],
            $this->request->getParams()['areaNo']
        );

        return $this->doSend([
            'result' => $this->model->updateData($data)
        ]);
    }


    public function doPost()
    {
        $data = ExperienceData::makeExperience(
            $this->request->getAttribute('uid'),
            null,
            $this->request->getParams()['firmName'],
            $this->request->getParams()['indCatNo'],
            $this->request->getParams()['jobName'],
            $this->request->getParams()['areaNo']
        );
        return $this->doSend([
            'result' => $this->model->addData($data)
        ]);
    }
}
