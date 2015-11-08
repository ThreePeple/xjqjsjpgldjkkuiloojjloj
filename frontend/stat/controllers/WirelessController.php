<?php

namespace app\stat\controllers;

use frontend\models\DeviceIpfilter;
use app\models\InfoConfig;
use app\models\ViewTemplate;
use app\models\WirelessDeviceAlarm;
use app\models\WirelessDeviceAp;
use app\models\WirelessDeviceInterface;
use app\models\WirelessDeviceLink;
use app\models\WirelessDeviceTask;
use frontend\models\WirelessDeviceTaskSummary;
use frontend\models\WirelessDeviceTaskSummarySearch;
use Yii;
use frontend\models\WirelessDeviceInfo;
use frontend\models\WirelessSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
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
     * Lists all WirelessDeviceInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$ips = DeviceIpfilter::getIdsByType(DeviceIpfilter::TYPE_WIRELESS);
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

        $perQuery = WirelessDeviceTaskSummary::find()
            ->where(["and",["devId"=>$id],["not",["taskId"=>[1,5]]]])
            ->orderBy("instId desc")
            ->groupBy('taskId');
        $lists = new ActiveDataProvider([
            'query' => $perQuery,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);

        $query = WirelessDeviceAlarm::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);
        $query->where(["deviceId"=>$id])->orderBy("faultTime desc")->limit(5);

        $links = $nodes = $linkModels = [];
        $nodes[] = [
            "name" => $model->ip,
            "id" => $model->id
        ];

        $apProvider = null;
        if($model->categoryId == 1003){

            $query = WirelessDeviceAp::find()->where(["acDevId"=>$id]);
            $apProvider = new ActiveDataProvider([
                "query" => $query,
                "pagination" => [
                    "pageSize" => 10
                ]
            ]);
        }else{
            $linkModels = WirelessDeviceLink::find()->where(["or",["leftDevice"=>$id],["rightDevice"=>$id]])->all();
            foreach ($linkModels as $link) {
                if($link->leftDevice == $id) {
                    $node = $link->right;
                }else{
                    $node = $link->left;
                }
                if(!$node) continue;
                $nodes[] = [
                    "name" => $node->ip,
                    "id" => $node->id
                ];
                $links[] = [
                  "source"=> $model->ip,
                    "target" => $node->ip,
                    "weight"=> 0.9
                ];
                $links[] = [
                    "source"=>$node->ip,
                    "target" => $model->ip,
                    "weight" => 1,
                ];
            }

        }

        $interfaceQuery = WirelessDeviceTaskSummary::find()
            ->where(["devId"=>$id,"taskId"=>[1,5]])
            ->orderBy("update_time desc")
            ->groupBy("taskId,objIndex");
        $interfaceProvider = new ActiveDataProvider([
            'query' => $interfaceQuery,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);

        return $this->render("detail_wlan",[
            'id'=>$id,
            "model"=>$model,
            "perflists" => $lists,
            "alarmProvider" =>$dataProvider,
            "nodes" =>$nodes,
            "links" => $links,
            "apProvider" => $apProvider,
            "ifProvider" => $interfaceProvider,
            'linkModels' => $linkModels
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
        $fromWhere = Yii::$app->request->get("fromWhere");
        if($fromWhere=='path'){
            return $this->pathDetail(Yii::$app->request->get("from"),Yii::$app->request->get("to"));
        }

        $device = WirelessDeviceInfo::find()->with(["type","model"])->where(["id"=>$id])->one();
        $deviceConfig =ArrayHelper::map(InfoConfig::getTipConfig(1),"key","value");
        $perfConfig = ArrayHelper::map(InfoConfig::getTipConfig(2),"key","value");
        $perfData = WirelessDeviceTaskSummary::find()->where(["taskId"=>array_values($perfConfig),"devId"=>$id])
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

    private function pathDetail($from,$to){
        $model = WirelessDeviceLink::find()->where(["or",["leftDevice"=>$from,"rightDevice"=>$to],["leftDevice"=>$to,
            "rightDevice"=>$from]])->one();
        if(!$model){
            return '链路不存在';
        }
        $alarmDatas = [];
        if($model->status !=1){
            $alarmDatas = (new Query())
                ->from('wireless_device_info a')
                ->innerJoin('wireless_device_alarm b',"a.id=b.deviceId")
                ->where(["and",["a.id"=>[$from,$to]],"a.status>0"])
                ->orderBy('b.id desc')
                ->groupBy('b.deviceId')
                ->all();
        }
        return $this->render("link-detail",[
            "model"=>$model,
            "alarmDatas" => $alarmDatas
        ]);
    }

    public function actionAjaxApTip(){
        $this->layout = false;
        $id = Yii::$app->request->get("id");
        $fromWhere = Yii::$app->request->get("fromWhere");
        if($fromWhere=='path'){
            $id1 = trim(Yii::$app->request->get("from"),'pid');
            $id2 = trim(Yii::$app->request->get("to"),'pid');
            return $this->pathDetail($id1,$id2);
        }
        $ap = WirelessDeviceAp::findOne($id);
        if(!$ap){
            return 'AP 不存在';
        }
        return $this->render("ap-tip",[
            "model" => $ap
        ]);
    }
}
