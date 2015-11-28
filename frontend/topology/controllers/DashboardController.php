<?php

namespace app\topology\controllers;

use frontend\models\DeviceAlarm;
use frontend\models\DeviceIpfilter;
use app\models\DeviceTask;
use app\models\TopologyConfig;
use app\models\WirelessDeviceAp;
use frontend\models\DeviceTaskSummary;
use frontend\models\WirelessDeviceInfo;
use app\models\WirelessDeviceLink;
use yii\base\View;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ViewTemplate;
use yii\helpers\Json;
use frontend\models\DeviceInfo;
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
    }

    public function actionImageBase64($fileName){
        $statusImgFileName = __DIR__ . "/../../web/images/warning.png";

        $absFileName = __DIR__ . "/../../web/images/". $fileName;
        if(file_exists($absFileName)){  
            list($bgWidth, $bgHeight, $bgType ) = getimagesize($absFileName); 
        
            $data = file_get_contents($absFileName);

            $bgDataUri = 'data:image/' . $bgType . ';base64,' . base64_encode($data);

            list($sImgWidth, $sImgHeight, $sImgType ) = getimagesize($statusImgFileName); 
            
            $data = file_get_contents($statusImgFileName);

            $statusImgDataUri = 'data:image/' . $sImgType . ';base64,' . base64_encode($data);
            header("Content-Type: image/svg+xml");

            echo ($this->renderPartial('_nodeSVG', 
                            array(
                                "bgImgDataUri" => $bgDataUri,
                                "statusImgDataUri" => $statusImgDataUri,
                                "bgImageWidth" => $bgWidth,
                                "bgImageHeight" => $bgHeight,
                                "statusImageWidth" => $sImgWidth,
                                "statusImageHeight" => $sImgHeight
                            ), true ) ); 
            
            return;
        }
        return "<Invalid Path>"; 
    }

    /**
     * 有线网络
     * @return string
     */
    public  function actionWlan(){

        return $this->render("wlan");
    }

    public function actionWlanPlane(){
        return $this->render("wlan_plane");
    }

    /**
     * 有线网络2   交换机组网
     */
    public function actionHubCompose(){
        return $this->render('polymerchart');
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
    public function actionAjaxWirelessEhub(){
        $id1 = Yii::$app->request->post("id1");
        $id2 = Yii::$app->request->post("id2");
        $data = WirelessDeviceLink::getEData($id1,$id2);
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
                "id" => "p2856",
                "label" => 'WLAN_AC_A',
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
            ->select(["label"=>"sysName","id"=>"CONCAT('id',id)","group"=>"CONCAT('group',side,':',CONCAT('id',id))","status"=>"status","device_id"=>"id","side"=>"side"])
            ->orderBy("ipAddress asc")
            ->asArray()->all();
        $groups = $links = [];
        $count = count($rows);
        foreach($rows as $k=>$one){
            $group = "group".($k<$count/2 ? 1:2);
            $polymers[0]["children"][] = $group.':'.$one["id"];
            $links[] = [
                "from"=> $one["id"],
                "to" => 'p2856',
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
        return DeviceTaskSummary::getLastPreDatas();
    }

    /**
     * 轮换视图
     */
    public function actionChangeView(){
        $this->layout = false;
        $uris = [
            1 => [
                '/topology/dashboard/index',
                '/topology/dashboard/wlan',
                '/topology/dashboard/hub-compose'
            ],
            2 => [
                "/topology/dashboard/wireless",
                "/topology/dashboard/wireless-hub",
                "/topology/dashboard/ac-ap"
            ],
        ];
        $type = Yii::$app->request->get('type',2);

        return $this->render('_changeView',[
            'uris' => $uris[$type]
        ]);
    }
}
