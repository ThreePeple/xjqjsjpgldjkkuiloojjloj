<?php

namespace app\input\controllers;

use app\models\JumperInfo;
use yii\base\ErrorException;
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
        $file = $_FILES[0]["tmp"];
        $reader = new \PHPExcel_Reader_Excel2007();
        if(!$reader->canRead($file)){
            $reader = new \PHPExcel_Reader_Excel5();
            if(!$reader->canRead($file)){
                throw new ErrorException("can not read file as Excel");
            }
        }

        $excel = $reader->load($file);
        $currentSheet = $excel->getActiveSheet();

    }

}
