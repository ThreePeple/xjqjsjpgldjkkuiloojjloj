<?php

namespace app\topology\controllers;

use app\models\DeviceIpfilter;
use app\models\WirelessDeviceInfo;
use app\models\WirelessDeviceLink;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ViewTemplate;
use yii\helpers\Json;
use app\models\DeviceInfo;
use Yii;
use app\models\DeviceLink;
use yii\helpers\ArrayHelper;

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
        $type = Yii::$app->request->post('type');
        if(!$type){
            $type = ViewTemplate::TYPE_BUILD;
        }
        $data = [];
        $selected = ViewTemplate::getTempateSet($type);
        $data["build"] = $selected;
        return Json::encode($data);
    }

    /**
     * 刷新面板数据
     */
    public function actionAjaxLinksRefresh(){
        $type = Yii::$app->request->post('type');
        if(!$type){
            $type = ViewTemplate::TYPE_BUILD;
        }
        $data = [];
        $selected = ViewTemplate::getTempateSet($type);
        $data["build"] = $selected;
        $data["links"] = array( 
                            array( "from" => "2", "to" => "3", "status" => "2" ),
                            array( "from" => "2", "to" => "4", "status" => "1" )
                        ); 
        return Json::encode($data);
    }


    /**
     * 有线网络
     * @return string
     */
    public  function actionWlan(){

        return $this->render("wlan");
    }

    /**
     * 有线网络2   交换机组网
     */
    public function actionHubCompose(){
        $rows = DeviceInfo::find()->where(["categoryId"=>12])->select(["id","label"])->asArray()->all();
        $first = 0;
        if(!empty($rows)){
            $first = $rows[0]["id"];
        }
        $ips = ["10.253.1.11","10.253.1.12","10.253.1.13","10.253.1.14"];
        //$rows = DeviceIpfilter::find()->where(["ip"=>$ips])->select(["id","label"])->asArray()->all();
        //$data = ArrayHelper::map($rows,"id","label");
        $data = [];
        return $this->render('polymerchart',[
            "cores" => $data,
            "firstCore" => 0
        ]);
    }

    public function actionAjaxGetHub(){
        $this->layout= false;
        $id1 = Yii::$app->request->post("id1");
        $id2 = Yii::$app->request->post("id2");

        //debug
        $id1 = 681;
        $id2 = 731;

        $data = DeviceLink::getPolymerData($id1,$id2);

        return Json::encode([
            'status'=> 1,
            "data" => $data
        ]);
    }

    /**
     * 无线网络图
     */
    public function actionWireless(){
        return $this->render("wireless");
    }

    /**
     * 区域设备链路图
     *
    $nodes = [
    ["id"=>1,"label"=>"交换机1","group"=>"switch"],
    ["id"=>2,"label"=>"交换机2","group"=>"switch"],
    ["id"=>3,"label"=>"服务器","group"=>"server"],
    ["id"=>4,"label"=>"防火墙","group"=>"firewall"],
    ["id"=>5,"label"=>"数据库","group"=>"db"],
    ];
    $edges = [
    ["id"=>1,"from"=>1,"to"=>2,"color"=>"green"],
    ["id"=>2,"from"=>1,"to"=>3,"color"=>"red"],
    ["id"=>3,"from"=>2,"to"=>4,"color"=>"green"],
    ["id"=>4,"from"=>2,"to"=>5,"color"=>"green","dashes"=>[5,5,3,3]],
    // ["id"=>5,"from"=>1,"to"=>5,"color"=>"red"],
    ];
     */
    public function  actionDeviceArea($area,$type){
        $group = ViewTemplate::$groups[$type];
        return $this->render("area",["area"=>$area,"type"=>$type,"group"=>json_encode($group)]);
    }
    /**
     * 获取区域设备和链路数据
     */
    public function actionAjaxGetNodes(){
        $area = Yii::$app->request->post("area");
        $type = Yii::$app->request->post("type",ViewTemplate::TYPE_WLAN);
        $nodes = ViewTemplate::getAreaDeviceData($area,$type);
        $ids = array_keys(ArrayHelper::map($nodes,"id","label"));
        $edges = ViewTemplate::getLinks($ids,$type);
        return Json::encode([
            "nodes" => $nodes,
            "edges" => $edges
        ]);
    }

    public function actionAjaxLinkDetail(){
        $this->layout = false;
        $id = Yii::$app->request->get("id");
        $type = Yii::$app->request->get("type");
        if($type == 3){
            $model = WirelessDeviceLink::findOne($id);
        }else{
            $model = DeviceLink::findOne($id);
        }
        return $this->render('link-detail',[
            "model" => $model
        ]);
    }

    public function actionAjaxLinks(){
        $type = Yii::$app->request->get("type");
        $ids = ViewTemplate::find()->where(["type"=>$type])->select("device_id")->column();
        if($type == ViewTemplate::TYPE_WIFI){
            $query = WirelessDeviceLink::find();
        }else{
            $query = DeviceLink::find();
        }
        $query->where(["or",["leftDevice"=>$ids],["rightDevice"=>$ids]])
            ->select(["from"=>"leftDevice","to"=>"rightDevice","status"=>"status"]);
        $links = $query->asArray()->all();
        return Json::encode($links);
    }

    /**
     * 图表数据
     */
    public function actionAjaxChartData(){

    }
}
