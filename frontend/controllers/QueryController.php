<?php

namespace frontend\controllers;

use app\models\RestfulClient;

class QueryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest(){
        $data = RestfulClient::get("http://223.72.164.195:8090/imcrs/plat/res/device/489/interface",[
            "start" => 0,
            "size" => 10,
            "desc"=>false,
            "total"=>false
        ])->getData();
        var_dump($data);
    }
}
