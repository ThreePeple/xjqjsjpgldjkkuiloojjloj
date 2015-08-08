<?php

namespace app\system\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->redirect(['/system/user/index']);
    }
}
