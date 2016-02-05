<?php

namespace bigc\rest\profile;

use \bigc\resume\model\Education;
use \bigc\resume\data\EducationData;
use \bigc\rest\BaseRest;

class EduRest extends BaseRest
{

    private $model;

    public function __construct()
    {
        //Call parent construct
        call_user_func_array('parent::__construct', func_get_args());

        $this->model = new Education;
    }
    public function doGets()
    {
        $datas = $this->model->getDatas($this->request->getAttribute('uid'));
        $res = [];
        foreach($datas as $data)
        {
            $tmp = [
                'uid'           => $data->getUid(),
                'eduid'         => $data->getEduId(),
                'schoolName'    => $data->getSchoolName(),
                'majorName'     => $data->getMajorName(),
                'majorCat'      => $data->getMajorCat(),
                'area'          => $data->getArea(),
                'schoolCountry' => $data->getSchoolCountry(),
                'startDate'     => $data->getStartDate(),
                'endDate'       => $data->getEndDate(),
                'degreeStatus'  => $data->getDegreeStatus()
            ];
            array_push($res, $tmp);
        }
        return $this->doSend(['result' => $res]);
    }

    public function doGet()
    {
        $uid = $this->request->getAttribute('uid');
        $eduid = $this->request->getAttribute('eduid');
        $data = $this->model->getData($uid, $eduid);
        $res = [
            'uid'           => $data->getUid(),
            'eduid'         => $data->getEduId(),
            'schoolName'    => $data->getSchoolName(),
            'majorName'     => $data->getMajorName(),
            'majorCat'      => $data->getMajorCat(),
            'area'          => $data->getArea(),
            'schoolCountry' => $data->getSchoolCountry(),
            'startDate'     => $data->getStartDate(),
            'endDate'       => $data->getEndDate(),
            'degreeStatus'  => $data->getDegreeStatus()
        ];
        return $this->doSend(['result' => $res]);
    }

    public function doDelete()
    {
        $uid = $this->request->getAttribute('uid');
        $eduid = $this->request->getAttribute('eduid');
        return $this->doSend([
            'result' => $this->model->deleteData($uid, $eduid)
        ]);
    }

    public function doPut()
    {
        $data = EducationData::makeEducation(
            $this->request->getAttribute('uid'),
            $this->request->getAttribute('eduid'),
            $this->request->getParams()['schoolName'],
            $this->request->getParams()['majorName'],
            $this->request->getParams()['majorCat'],
            $this->request->getParams()['area'],
            $this->request->getParams()['schoolCountry'],
            $this->request->getParams()['startDate'],
            $this->request->getParams()['startDate'],
            $this->request->getParams()['degreeStatus']
        );

        return $this->doSend([
            'result' => $this->model->updateData($data)
        ]);
    }


    public function doPost()
    {
        $data = EducationData::makeEducation(
            $this->request->getAttribute('uid'),
            null,
            $this->request->getParams()['schoolName'],
            $this->request->getParams()['majorName'],
            $this->request->getParams()['majorCat'],
            $this->request->getParams()['area'],
            $this->request->getParams()['schoolCountry'],
            $this->request->getParams()['startDate'],
            $this->request->getParams()['startDate'],
            $this->request->getParams()['degreeStatus']
        );
        return $this->doSend([
            'result' => $this->model->addData($data)
        ]);
    }
}
