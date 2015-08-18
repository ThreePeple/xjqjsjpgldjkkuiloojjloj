<?php

namespace app\topology\controllers;

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
        $data = [];

        $data["groups"]=[
            "group1" => [
                ["label"=>"LABEL 0","id"=>"ida0"],
                ["label"=>"LABEL 1","id"=>"ida1"],
                ["label"=>"LABEL 2","id"=>"ida2"],
                ["label"=>"LABEL 3","id"=>"ida3"],
                ["label"=>"LABEL 4","id"=>"ida4"],
                ["label"=>"LABEL 5","id"=>"ida5"],
            ],
            "group2" => [
                ["label"=>"LABEL 0","id"=>"idb0"],
                ["label"=>"LABEL 1","id"=>"idb1"],
                ["label"=>"LABEL 2","id"=>"idb2"],
                ["label"=>"LABEL 3","id"=>"idb3"],
                ["label"=>"LABEL 4","id"=>"idb4"],
                ["label"=>"LABEL 5","id"=>"idb5"],
            ],
        ];

        $data["polymers"] = [
            [
                "id" => "p1",
                "label" => "聚会交换机1",
                "children" => [
                    "group1:ida0",
                    "group1:ida1",
                    "group1:ida2",
                    "group1:ida3",
                    "group1:ida4",
                    "group1:ida5",
                    "group2:idb0",
                    "group2:idb1",
                    "group2:idb2",
                    "group2:idb3",
                    "group2:idb4",
                    "group2:idb5"
                ]
            ],
            [
                "id" => "p2",
                "label" => "聚会交换机2",
                "children" => [
                    "group1:ida0",
                    "group1:ida1",
                    "group1:ida2",
                    "group1:ida3",
                    "group1:ida4",
                    "group1:ida5",
                    "group2:idb0",
                    "group2:idb1",
                    "group2:idb2",
                    "group2:idb3",
                    "group2:idb4",
                   // "group2:idb5"
                ]
            ],

        ];
        return $this->render('polymerchart',[
            "data" => json_encode($data)
        ]);
    }

    public function actionAjaxGetHub(){
        $this->layout= false;
        $core_id = Yii::$app->request->post("core_id");
        $data = DeviceLink::getPolymerData($core_id);
            /*
        $data["groups"]=[
            "group1" => [
                ["label"=>"LABEL 0","id"=>"ida0"],
                ["label"=>"LABEL 1","id"=>"ida1"],
                ["label"=>"LABEL 2","id"=>"ida2"],
                ["label"=>"LABEL 3","id"=>"ida3"],
                ["label"=>"LABEL 4","id"=>"ida4"],
                ["label"=>"LABEL 5","id"=>"ida5"],
            ],
            "group2" => [
                ["label"=>"LABEL 0","id"=>"idb0"],
                ["label"=>"LABEL 1","id"=>"idb1"],
                ["label"=>"LABEL 2","id"=>"idb2"],
                ["label"=>"LABEL 3","id"=>"idb3"],
                ["label"=>"LABEL 4","id"=>"idb4"],
                ["label"=>"LABEL 5","id"=>"idb5"],
            ],
        ];

        $data["polymers"] = [
            [
                "id" => "p1",
                "label" => "聚会交换机1",
                "children" => [
                    "group1:ida0",
                    "group1:ida1",
                    "group1:ida2",
                    "group1:ida3",
                    "group1:ida4",
                    "group1:ida5",
                    "group2:idb0",
                    "group2:idb1",
                    "group2:idb2",
                    "group2:idb3",
                    "group2:idb4",
                    "group2:idb5"
                ]
            ],
            [
                "id" => "p2",
                "label" => "聚会交换机2",
                "children" => [
                    "group1:ida0",
                    "group1:ida1",
                    "group1:ida2",
                    "group1:ida3",
                    "group1:ida4",
                    "group1:ida5",
                    "group2:idb0",
                    "group2:idb1",
                    "group2:idb2",
                    "group2:idb3",
                    "group2:idb4",
                    // "group2:idb5"
                ]
            ]
        ];
            */

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
        return $this->render("area",["area"=>$area,"type"=>$type]);
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

    public function actionTest(){
        $area = [[0,0],[100,10],[100,100],[10,100]];

        $r = ViewTemplate::isInArea([11,100],$area);
        var_dump($r);
    }
}
