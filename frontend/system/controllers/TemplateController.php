<?php

namespace app\system\controllers;

use yii\helpers\Json;
use app\models\DeviceInfo;
use yii\helpers\ArrayHelper;
use app\models\ViewTemplate;

class TemplateController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $lists = DeviceInfo::getSelect2List();
        $selected = [];
        $lists = ArrayHelper::map($lists,'id','text');
        return $this->render('editor',["lists"=>$lists,"selected"=>$selected]);
    }

    public function actionAjaxItems($q=null){
        $data = DeviceInfo::getSelect2List(null,$q,[]);
        return Json::encode(["results"=>$data]);
    }

    /**
     * 保存模板
     */
    public function actionTest(){
        $data = ViewTemplate::getTempateSet(1);
        var_dump($data);
    }
}
