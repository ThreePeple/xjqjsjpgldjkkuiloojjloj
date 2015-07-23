<?php

namespace app\system\controllers;

class TemplateController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('editor');
    }
}
