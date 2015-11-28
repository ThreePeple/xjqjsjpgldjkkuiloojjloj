<?php

namespace app\system\controllers;

use app\models\DeviceCategory;
use frontend\models\WirelessDeviceCategory;
use frontend\models\WirelessDeviceInfo;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Json;
use frontend\models\DeviceInfo;
use yii\helpers\ArrayHelper;
use app\models\ViewTemplate;
use Yii;
use app\models\Area;

class TemplateController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules' =>[
                    [
                        'allow'=>true,
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => false,
                        'roles'=>['operator'],
                        'denyCallback' => function($rule,$action){
                            return $this->redirect(['/site/login']);
                        }
                    ],
                ]
            ]
        ];
    }
    public function actionBuilding()
    {
        $lists = DeviceInfo::getSelect2List(ViewTemplate::TYPE_BUILD);
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_BUILD);
       // $lists = ArrayHelper::map($lists,'id','text');
        return $this->render('editor',["lists"=>$lists,"selected"=>Json::encode($selected, JSON_FORCE_OBJECT),"type"=>ViewTemplate::TYPE_BUILD]);
    }
    /**
     * 获取大厦可选设备列表
     */
    public function actionAjaxItems($q=null){
        $data = DeviceInfo::getSelect2List(null,$q,[]);
        return Json::encode(["results"=>$data]);
    }

    /**
     * 保存模板
     */
    public function actionSave(){
        $type = Yii::$app->request->post("dataType",0);
        $data = Yii::$app->request->post("data");
        $result = ["status"=> 0,'msg'=>''];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            ViewTemplate::deleteAll(["type"=>$type]);
            $data = json_decode($data,true);
            $data = array_filter($data);
            foreach($data as $k=>$item){
                $model = new ViewTemplate();
                $model->id = $k;
                $model->attributes = json_encode($item["attributes"]);
                $model->links = isset($item["links"])? json_encode($item["links"]):null;
                $model->type = $type;
                $model->device_id = $item["data"]["id"];
                $model->areaId = $model->getAreaId($item["attributes"]["cx"],$item["attributes"]["cy"]);
                if(!$model->save()){
                    $transaction->rollback();
                    throw new Exception("item error:".$item["data"]["label"].print_r($model->getErrors(),true));
                }
            }
            $transaction->commit();
            $result["status"] = 1;
        }catch (Exception $e){
            $transaction->rollback();
            $result["msg"] = $e->getMessage();
        }
        return Json::encode($result);
    }

    /**
     * 有限网络
     */
    public function actionWlan(){
        $lists = DeviceInfo::getDeviceList(ViewTemplate::TYPE_WLAN);
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_WLAN);
        //$areaList = Area::find()->select(["id","name"])->asArray()->all();
        //$areaList = ArrayHelper::map($areaList,"id","name");
        $categorys = ArrayHelper::map(DeviceCategory::find()->all(),"node_group","name");

        return $this->render('editorWlan',[
            //"areaList"=>$areaList,
            "deviceList"=>$lists,
            "selected"=>Json::encode($selected),
            "type"=>ViewTemplate::TYPE_WLAN,
            "categorys" => $categorys
        ]);
    }
    /**
     * 有限网络(plane)
     */
    public function actionWlanPlane(){
        $lists = DeviceInfo::getDeviceList(ViewTemplate::TYPE_WLAN_PLANE);
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_WLAN_PLANE);
        $categorys = ArrayHelper::map(DeviceCategory::find()->all(),"node_group","name");

        return $this->render('editorWlanPlane',[
            "deviceList"=>$lists,
            "selected"=>Json::encode($selected),
            "type"=>ViewTemplate::TYPE_WLAN_PLANE,
            "categorys" => $categorys
        ]);
    }
    /**
     * 无线网络
     */
    public function actionWireless(){
        $lists = WirelessDeviceInfo::getDeviceList();
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_WIFI);
        $categorys = ArrayHelper::map(WirelessDeviceCategory::find()->all(),"node_group","name");

        return $this->render('editWireless',[
            'deviceList' => $lists,
            'selected' => json_encode($selected),
            'type' => ViewTemplate::TYPE_WIFI,
            "categorys" => $categorys

        ]);

    }

    public function actionTest(){
        $f = ViewTemplate::isInArea([371,272],[[305,144],[110,233],[387,414],[588,312]]);
        var_dump($f);
    }
}
