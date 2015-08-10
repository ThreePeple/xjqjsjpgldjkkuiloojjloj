<?php

namespace app\stat\controllers;

use app\models\WirelessDeviceAlarm;
use app\models\WirelessDeviceInterface;
use app\models\WirelessDeviceLink;
use app\models\WirelessDeviceTask;
use Yii;
use app\models\WirelessDeviceInfo;
use app\models\WirelessSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WirelessController implements the CRUD actions for WirelessDeviceInfo model.
 */
class WirelessController extends Controller
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
     * Lists all WirelessDeviceInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WirelessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WirelessDeviceInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WirelessDeviceInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WirelessDeviceInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WirelessDeviceInfo model.
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
     * Deletes an existing WirelessDeviceInfo model.
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
     * Finds the WirelessDeviceInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WirelessDeviceInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WirelessDeviceInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetNodes(){
        $id = Yii::$app->request->get("id");
        $model = $this->findModel($id);
        $data = [
            "name" => $model->label,
            "children" => []
        ];
        $childrens = WirelessDeviceInterface::find()->where(["device_id"=>$model->id])->select(["name"=>"ifDescription","id"=>"ifIndex"])->asArray()->all();
        $data["children"] = $childrens;
        return Json::encode($data);
    }
    /**
     * 接口详情
     */
    public function actionGetDetail(){
        $id = Yii::$app->request->get("node");
        $data = WirelessDeviceInterface::find()->where(["id"=>$id])->asArray()->one();
        return Json::encode(["result"=>1,"data"=>$data]);
    }
    /**
     * 设备接口
     */
    public function actionInterface($id){
        return $this->render('link',['id'=>$id]);
    }

    public function actionDetail($id){
        $this->layout = '//main';
        $model = $this->findModel($id);
        $lists = WirelessDeviceTask::getPrefList($id);
        $query = WirelessDeviceAlarm::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);
        $query->where(["deviceId"=>$id])->orderBy("faultTime desc")->limit(5);

        $links = WirelessDeviceLink::find();
        $links->where(["or",["leftDevice"=>$id],["rightDevice"=>$id]]);
        $linkProvider = new ActiveDataProvider([
            'query'=>$links
        ]);

        return $this->render("detail_wlan",[
            'id'=>$id,
            "model"=>$model,
            "perflists" => $lists,
            "alarmProvider" =>$dataProvider,
            "links" =>$linkProvider,
        ]);
    }
    /**
     * 设备性能指标
     */
    public function actionPerf($id){
        $this->layout = false;
        $lists = WirelessDeviceTask::getPrefList($id);
        return $this->render('perf', [
            'data' => $lists,
            "devId" => $id
        ]);
    }

    public function actionAjaxDeviceTip(){
        $this->layout = false;
        $id = Yii::$app->request->get("id");
        $device = WirelessDeviceInfo::find()->with(["type","model"])->where(["id"=>$id])->one();
        return $this->render("tip",["model"=>$device]);
    }
}
