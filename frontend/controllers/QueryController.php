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
        RestfulClient::get("/device",["id"=>1]);
    }
}
