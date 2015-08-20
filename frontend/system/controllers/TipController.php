<?php

namespace app\system\controllers;

use app\models\InfoConfig;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Response;

class TipController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $content1 = $this->getContent(1);
        $content2 = $this->getContent(2);
        return $this->render('index',[
            "content1" => $content1,
            "content2" => $content2
        ]);
    }

    public function getContent($type){
        $query = InfoConfig::find()->where(["type_id"=>$type]);
        $dataProvider = new ActiveDataProvider([
            "query" => $query
        ]);
        return $this->renderPartial("content",[
            "dataProvider" => $dataProvider,
            "type" => $type
        ]);
    }

    public function actionSaveConfig(){
        $selected = \Yii::$app->request->post("selected");
        $type = \Yii::$app->request->post("type");

        InfoConfig::updateAll(["is_show"=>0],["type_id"=>$type]);
        InfoConfig::updateAll(["is_show"=>1],["type_id" => $type,"id"=>$selected]);
        return Json::encode(["status"=>1]);
    }
}
