<?php

namespace app\input\controllers;

use yii\data\ArrayDataProvider;

class ConfigSetController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        // TODO接口取数据
        $data = [
            [
                "ip" => "10.6.251.21",
                "mac" => '00:0f:e2:66:db:2d',
                "status" => '正常',
                "id" => 1
            ],
            [
                "ip" => "10.6.251.52",
                "mac" => '00:0f:e2:62:cb:4d',
                "status" => '正常',
                "id" => 2
            ]

        ];
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);

        return $this->render("index",[
            'dataProvider'=>$dataProvider,
        ]);
    }

    public function actionDelete($id){
        //todo
    }

    public function actionSend(){
        //TODO
    }
}
