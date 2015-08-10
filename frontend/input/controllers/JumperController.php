<?php

namespace app\input\controllers;

use app\models\JumperInfo;
use yii\data\ActiveDataProvider;

class JumperController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = JumperInfo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);
        return $this->render("index",[
            'dataProvider'=>$dataProvider,
        ]);
    }

    public function actionImport(){

    }

}
