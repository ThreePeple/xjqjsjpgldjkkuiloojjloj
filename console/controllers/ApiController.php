<?php

namespace console\controllers;
use yii\log\Logger;
use yii\base\Exception;
use Yii;
use yii\helpers\Json;

class ApiController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
