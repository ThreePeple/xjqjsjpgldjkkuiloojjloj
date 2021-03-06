<?php

namespace app\stat\controllers;

use app\models\DeviceInterface;
use frontend\models\DeviceIpfilter;
use app\models\InfoConfig;
use app\models\TopologyConfig;
use frontend\models\DeviceTaskSummary;
use frontend\models\DeviceTaskSummarySearch;
use Yii;
use frontend\models\DeviceInfo;
use frontend\models\DeviceInfoSearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use frontend\models\DeviceInterfaceTask;
use app\models\DeviceTask;
use frontend\models\DeviceAlarm;
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
            'access' => [
                'class' => AccessControl::className(),
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
       // $ips = DeviceIpfilter::getIdsByType([DeviceIpfilter::TYPE_WLAN,DeviceIpfilter::TYPE_POLYMER]);
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
        //$lists = DeviceTask::getPrefList($id);
        $perfQuery = DeviceTaskSummary::find()
            ->where(["and",["devId"=>$id],["not",["taskId"=>[1,5]]]])
            ->orderBy("instId desc")
            ->groupBy('taskId');
        $lists = new ActiveDataProvider([
            'query' => $perfQuery,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);

        $query = DeviceAlarm::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);
        $query->where(["deviceId"=>$id])->orderBy("faultTime desc")->limit(5);

        $interQuery = DeviceTaskSummary::find()
            ->where(['devId'=>$id,"taskId"=>[1,5]])
            ->orderBy("instId desc")
            ->groupBy('taskId,objIndex');
        $interfaceProvider = new ActiveDataProvider([
            'query' => $interQuery,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);

        return $this->render("detail",[
            'id'=>$id,
            "model"=>$model,
            "perflists" => $lists,
            "alarmProvider" =>$dataProvider,
            "interfaceProvider" => $interfaceProvider
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

    /**
     * 设备TIP
     * @return string
     */
    public function actionAjaxDeviceTip(){
        $this->layout = false;
        $id = Yii::$app->request->get("id");
        $fromWhere = Yii::$app->request->get("fromWhere");
        if($fromWhere=='path'){
            $id1 = trim(Yii::$app->request->get("from"),'pid');
            $id2 = trim(Yii::$app->request->get("to"),'pid');
            return $this->getLinkTip($id1,$id2);
        }else{
            return $this->getTip($id);
        }
    }

    private function pathDetail($from,$to){
        $model = WirelessDeviceLink::find()->where(["or",["leftDevice"=>$from,"rightDevice"=>$to],["leftDevice"=>$to,
            "rightDevice"=>$from]])->one();
        if(!$model){
            return '链路不存在';
        }
        return $this->render("link-detail",[
            "model"=>$model
        ]);
    }

    /**
     * 有线拓扑 根据nodeId 获取设备TIP
     */
    public function actionAjaxNodeTip(){
        $nodeId = Yii::$app->request->get("id");
        $row = TopologyConfig::find()->where(["id"=>$nodeId])->select("device1,device2,type_id")->one();
        switch($row["type_id"]){
            case 1:
                $id = DeviceInfo::find()->where(["ip"=>$row["device1"]])->select("id")->scalar();
                return $this->getTip($id);
            case 2:
                $ids = DeviceInfo::find()->where(["ip"=>[$row["device1"],$row["device2"]]])->select("id")->column();
                if(count($ids) ==2){
                    return $this->getLinkTip($ids[0],$ids[1]);
                }
            default:
                return '参数错误';
        }
    }

    /**
     * 设备提示信息
     * @param $deviceId
     * @return string
     */
    protected function getTip($deviceId){
        $this->layout = false;
        $device = DeviceInfo::find()->with(["type","model"])->where(["id"=>$deviceId])->one();
        if(!$device){
            return "设备未找到";
        }

        $deviceConfig =ArrayHelper::map(InfoConfig::getTipConfig(1),"key","value");
        $perfConfig = ArrayHelper::map(InfoConfig::getTipConfig(2),"key","value");
        $perfData = DeviceTaskSummary::find()->where(["taskId"=>array_values($perfConfig),"devId"=>$deviceId])
            ->select(["taskId","currentValue"])
            ->groupBy("taskId")
            ->asArray()
            ->all();
        $perfData = ArrayHelper::map($perfData,"taskId","currentValue");
        return $this->render("tip",[
            "model"=>$device,
            "deviceConfig"=>$deviceConfig,
            "perfConfig" => $perfConfig,
            "perfData" => $perfData
        ]);
    }
    /**
     * 链路提示信息
     */
    public function getLinkTip($d1,$d2){
        $this->layout = false;
        $model = DeviceLink::find()
            ->where(["or",["and",["leftDevice"=>$d1,"rightDevice"=>$d2]],["and",["leftDevice"=>$d2,"rightDevice"=>$d1]]])
            ->one();
        if(!$model){
            return '链路不存在';
        }
        $alarmDatas = [];
        /*
        if($model->status > 1){
            $alarmDatas = (new Query())
                ->from('device_info a')
                ->innerJoin('device_alarm b',"a.id=b.deviceId")
                ->where(["and",["a.id"=>[$d1,$d2]],"a.status>0",['not like','b.alarmDesc','GigabitEthernet1/1/1']])
                ->all();
        }*/
        return $this->render('link-detail',[
            "model" => $model,
            "alarmDatas" => $alarmDatas
        ]);
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
