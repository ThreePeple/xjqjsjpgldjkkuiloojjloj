<?php

namespace app\system\controllers;

use yii\base\Exception;
use yii\helpers\Json;
use app\models\DeviceInfo;
use yii\helpers\ArrayHelper;
use app\models\ViewTemplate;
use Yii;
use app\models\Area;

class TemplateController extends \yii\web\Controller
{
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
                $model->areaId = isset($item["data"]["areaId"]) ? $item["data"]["areaId"] : null;
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
        $lists = DeviceInfo::getWlanList(ViewTemplate::TYPE_WLAN);
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_WLAN);
        $areaList = Area::find()->select(["id","name"])->asArray()->all();
        $areaList = ArrayHelper::map($areaList,"id","name");
        return $this->render('editorWlan',["areaList"=>$areaList,"deviceList"=>$lists,"selected"=>Json::encode($selected),"type"=>ViewTemplate::TYPE_WLAN]);
    }

    public function actionTest(){
        $f = ViewTemplate::isInArea([371,272],[[305,144],[110,233],[387,414],[588,312]]);
        var_dump($f);
    }
}
