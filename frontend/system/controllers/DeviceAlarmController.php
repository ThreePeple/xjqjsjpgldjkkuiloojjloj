<?php

namespace app\system\controllers;

use app\models\WirelessDeviceAlarm;
use app\models\WirelessDeviceAlarmSearch;
use Yii;
use app\models\DeviceAlarm;
use app\models\DeviceAlarmSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeviceAlarmController implements the CRUD actions for DeviceAlarm model.
 */
class DeviceAlarmController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all DeviceAlarm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeviceAlarmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => "设备告警列表"
        ]);
    }

    public function actionWirelessList(){
        $searchModel = new WirelessDeviceAlarmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => "无线设备告警列表"
        ]);
    }

    /**
     * Displays a single DeviceAlarm model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $type = Yii::$app->request->get("type");
        return $this->render('view', [
            'model' => $this->findModel($id,$type),
        ]);
    }

    /**
     * Creates a new DeviceAlarm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeviceAlarm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DeviceAlarm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DeviceAlarm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 消息设置 告警条件设置   发送人    发送设置
     */
    public function actionSmsConfig(){


    }

    /**
     * Finds the DeviceAlarm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeviceAlarm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$type=null)
    {
        if($type ==2 && ($model = WirelessDeviceAlarm::findOne($id)) !== null){
            return $model;
        }elseif (($model = DeviceAlarm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
