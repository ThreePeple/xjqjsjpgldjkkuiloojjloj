<?php

namespace app\system\controllers;

use app\models\InfoConfig;
use yii\data\ArrayDataProvider;
use yii\web\Response;

class TipController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAjaxGetContent(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $this->layout = false;

        $type = \Yii::$app->request->get("type",1);

        $query = InfoConfig::find()->where(["type_id"=>$type]);
        $dataProvider = new ArrayDataProvider([
            "allModels" => $query->all()
        ]);
        return $this->render("content",[
            "dataProvider" => $dataProvider,
            "type" => $type
        ]);
    }
}
