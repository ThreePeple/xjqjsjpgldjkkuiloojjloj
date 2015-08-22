<?php

namespace console\controllers;
use yii\log\Logger;
use yii\base\Exception;
use Yii;
use yii\helpers\Json;
use app\models\RestfulClient;

class ApiController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 无线设备相关资源任务
     */
    public function actionWirelessDeviceSourceTask()
    {
       $host=Yii::$app->params[''];
    }
}
