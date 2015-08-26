<?php

namespace app\topology\controllers;

use app\models\DeviceAlarm;
use app\models\DeviceIpfilter;
use app\models\DeviceTask;
use app\models\TopologyConfig;
use app\models\WirelessDeviceAp;
use app\models\WirelessDeviceInfo;
use app\models\WirelessDeviceLink;
use yii\base\View;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ViewTemplate;
use yii\helpers\Json;
use app\models\DeviceInfo;
use Yii;
use app\models\DeviceLink;
use yii\helpers\ArrayHelper;
use yii\web\Response;

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
     * 刷新面板、链路数据
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

       /* $data["mainLinks"] = array(
                                "r" => array( "status" => rand(1, 2) ),
                                "g" => array( "status" => rand(1, 2) ),
                                "b" => array( "status" => rand(1, 2) )
                            );*/
        if($type == ViewTemplate::TYPE_WIFI){
            $data["mainLinks"] = [
                "r" => ["status"=> WirelessDeviceLink::getWirelessLinkStatus(1)],
                "g" =>["status" => WirelessDeviceLink::getWirelessLinkStatus(2)] ,
                "b" => ["status"=>WirelessDeviceLink::getWirelessLinkStatus(3)],
            ];
        }

        return Json::encode($data);
    }

    /**
     * 有线网络新的状态更新服务
     *
     * 
     * @return [String] json string
     */
    public function actionAjaxWlanRefresh(){
        $nodes = TopologyConfig::getWlanLinkStatus();
        $links = TopologyConfig::getWlanNodeStatus();

        $data = array_merge($nodes,$links);
        return  json_encode($data);


 $rand1 = rand(1, 2);
 $rand2 = rand(1, 2);

$jsonData = <<<abc
{
    "element_node_5": {
        "status": $rand1
    },
    "element_node_32": {
        "status": $rand2
    },
    "element_line_16":{
        "status": $rand2 
    },
    "element_line_29":{
        "status": $rand1 
    }
}
abc;
        return $jsonData;

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
       /* 页面写死IP 不需要获取数据了
        $rows = DeviceInfo::find()->where(["categoryId"=>12])->select(["id","label"])->asArray()->all();
        $first = 0;
        if(!empty($rows)){
            $first = $rows[0]["id"];
        }
        $ips = ["10.253.1.11","10.253.1.12","10.253.1.13","10.253.1.14"];
        $rows = (new Query())
            ->from("device_ipfilter a")
            ->leftJoin("device_info b","a.ip = b.ip")
            ->where(["a.ip"=>$ips])
            ->select(["b.id","b.label","b.ip","group"=>"IF(b.ip='10.253.1.11' or b.ip='10.253.1.12',1,2)"])
            ->orderBy("group asc")
            ->all();
        //$rows = DeviceIpfilter::find()->where(["ip"=>$ips])->select(["ip","label","group"=>"IF(ip='10.253.1.11' or ip='10.253.1.13',1,2)"])->asArray()->all();
        $data = ArrayHelper::map($rows,"id",function($data){
            return ["label"=>$data["label"],"group"=>$data["group"],"id"=>$data["id"]];
        });
        $groups = [];
        foreach($data as $key=>$row){
            $groups[$row["group"]][] = $row["id"];

        }
       */
        return $this->render('polymerchart',[
          //  "polymers" => $data,
           // "groups" => $groups
        ]);
    }

    /**
     * 交换机组网数据
     * @return string
     */
    public function actionAjaxGetHub(){
        $this->layout= false;
        $id1 = Yii::$app->request->post("id1");
        $id2 = Yii::$app->request->post("id2");

        $data = DeviceLink::getPolymerData($id1,$id2);
/*
        $data["links"] = array(
                array( "from" => "id766", "to" => "p1", "status" => "1" ),
                array( "from" => "id825", "to" => "p1", "status" => "2" ),

            );*/

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
     * 无线网： 接入网络拓扑
     */
    public function actionWirelessHub(){
        return $this->render("wireless_hub");
    }
    public function actionAjaxWirelessHub(){
        $id1 = Yii::$app->request->post("id1");
        $id2 = Yii::$app->request->post("id2");
        $data = WirelessDeviceLink::getPolymerData($id1,$id2);

        return Json::encode([
            'status'=> 1,
            "data" => $data
        ]);
    }
    /**
     * AC / AP
     */
    public function actionAcAp(){
        return $this->render('ac-ap');
    }
    public function actionAjaxAcAp(){
        $area = Yii::$app->request->post("area");
        $polymers = [
            [
                "id" => "p1",
                "label" => '192.168.0.4',
                "children" =>[]
            ]
        ];
        /*
        $rows = (new Query())
            ->from("wireless_device_ap a")
            ->leftJoin("wireless_device_link b","((a.id=b.leftDevice and a.acDevId=b.rightDevice) or (a.id=b
            .rightDevice and a.acDevId=b.leftDevice))")
            ->where(["a.acIpAddress"=>'192.168.0.4',"a.area"=>$area])
            ->select(["label"=>"ipAddress","id"=>"CONCAT('id',a.id)","group"=>"CONCAT('group',a.side,':',CONCAT('id',a.id))","status"=>"a.status","device_id"=>"a.id","linkStatus"=>"b.status","side"=>"a.side"])
            ->all();
        */
        $rows = WirelessDeviceAp::find()
            ->where(["acIpAddress"=>'192.168.0.4',"area"=>$area])
            ->select(["label"=>"ipAddress","id"=>"CONCAT('id',id)","group"=>"CONCAT('group',side,':',CONCAT('id',id))","status"=>"status","device_id"=>"id","side"=>"side"])
            ->orderBy("ipAddress asc")
            ->asArray()->all();
        $groups = $links = [];
        $count = count($rows);
        foreach($rows as $k=>$one){
            $group = "group".($k<$count/2 ? 1:2);
            $polymers[0]["children"][] = $group.':'.$one["id"];
            $links[] = [
                "from"=> $one["id"],
                "to" => 'p1',
                "status" => 1
            ];
            $groups[$group][] = $one;
        }
        return json_encode([
            "status"=> 1,
            "data" => [
                "groups" => $groups,
                "polymers" => $polymers,
                "links" => $links
            ]
        ]);
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
        $deviceData = DeviceInfo::getDeviceCountStat();

        $alarmTypes = DeviceAlarm::getTypeChartData();
        $alarmLevels = DeviceAlarm::getLevelChartData();

        return json_encode([
            "device" => $deviceData,
            "alarmType" => $alarmTypes,
            "alarmLevel" => $alarmLevels
        ]);
    }

    /**
     * 大厦滚动性能信息
     */
    public function actionGetMarqueeData(){
        return DeviceTask::getLastPreDatas();
    }
}
