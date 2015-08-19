<?php

namespace app\stat\controllers;

use app\models\DeviceInterface;
use app\models\InfoConfig;
use Yii;
use app\models\DeviceInfo;
use app\models\DeviceInfoSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\models\DeviceInterfaceTask;
use app\models\DeviceTask;
use app\models\DeviceAlarm;
use yii\data\ActiveDataProvider;
use app\models\DeviceLink;

/**
 * DeviceController implements the CRUD actions for DeviceInfo model.
 */
class DeviceController extends Controller
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
     * Lists all DeviceInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeviceInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeviceInfo model.
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
     * Creates a new DeviceInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeviceInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DeviceInfo model.
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
     * Deletes an existing DeviceInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetNodes(){
        $id = Yii::$app->request->get("id");
        $model = $this->findModel($id);
        $data = [
            "name" => $model->label,
            "children" => []
        ];
        $childrens = DeviceInterface::find()->where(["device_id"=>$model->id])->select(["name"=>"ifDescription","id"=>"ifIndex"])->asArray()->all();
        $data["children"] = $childrens;
        return Json::encode($data);
    }

    /**
     * 接口详情
     */
    public function actionGetDetail(){
        $id = Yii::$app->request->get("node");
        $data = DeviceInterface::find()->where(["id"=>$id])->asArray()->one();
        return Json::encode(["result"=>1,"data"=>$data]);
    }
    /**
     * 设备接口
     */
    public function actionInterface($id){
        return $this->render('link',['id'=>$id]);
    }

    /**
     * 设备详情页面
     */
    public function actionDetail($id){
        $this->layout = '//main';
        $model = $this->findModel($id);
        $lists = DeviceTask::getPrefList($id);
        $query = DeviceAlarm::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);
        $query->where(["deviceId"=>$id])->orderBy("faultTime desc")->limit(5);
        return $this->render("detail",[
            'id'=>$id,
            "model"=>$model,
            "perflists" => $lists,
            "alarmProvider" =>$dataProvider
        ]);
    }
    public function actionWlanDetail($id){
        $this->layout = '//main';
        $model = $this->findModel($id);
        $lists = DeviceTask::getPrefList($id);
        $query = DeviceAlarm::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->where(["deviceId"=>$id])->orderBy("faultTime desc")->limit(5);

        $links = DeviceLink::find();
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
        $lists = DeviceTask::getPrefList($id);
        return $this->render('perf', [
            'data' => $lists,
            "devId" => $id
        ]);
    }

    public function actionAjaxDeviceTip(){
        $this->layout = false;
        $id = Yii::$app->request->get("id");
        $device = DeviceInfo::find()->with(["type","model"])->where(["id"=>$id])->one();
        $deviceConfig =ArrayHelper::map(InfoConfig::getTipConfig(1),"key","value");
        $perfConfig = InfoConfig::getTipConfig(2);
        return $this->render("tip",[
            "model"=>$device,
            "deviceConfig"=>$deviceConfig
        ]);
    }

    private function getPerfInfos($config){
        $ids = ArrayHelper::map($config,"key","value");
    }
    /**
     * Finds the DeviceInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeviceInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$type = 2)
    {
        if (($model = DeviceInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
