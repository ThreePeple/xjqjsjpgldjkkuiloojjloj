<?php

namespace frontend\controllers;

use app\models\DeviceLink;
use app\models\RestfulClient;

class QueryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest(){
        $data = DeviceLink::getPolymerData(681,731);
        var_dump($data);

    }
}
