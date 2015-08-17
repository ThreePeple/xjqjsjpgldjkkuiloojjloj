<?php

namespace app\topology\controllers;

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

    public  function actionWlan(){

        return $this->render("wlan");
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
        $edges = ViewTemplate::getLinks($ids);
        return Json::encode([
            "nodes" => $nodes,
            "edges" => $edges
        ]);
    }

    public function actionAjaxLinkDetail(){
        $id = Yii::$app->request->get("id");
        $type = Yii::$app->request->get("type");
        return 'tobe done';
    }

    public function actionTest(){
        $data = ViewTemplate::getAreaDeviceData(1,1);
        var_dump($data);
        /*$m = DeviceInfo::find()->with(["category"])->where(["id"=>2])->asArray()->one();
        var_dump($m);*/
    }
}
