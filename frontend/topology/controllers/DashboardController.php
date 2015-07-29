<?php

namespace app\topology\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ViewTemplate;
use yii\helpers\Json;

class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 刷新面板数据
     */
    public function actionAjaxRefresh(){
        $data = [];
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_BUILD);
        $data["build"] = $selected;
        return Json::encode($data);
    }
}
