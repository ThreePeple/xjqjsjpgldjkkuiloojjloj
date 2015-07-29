<?php

namespace app\system\controllers;

use yii\base\Exception;
use yii\helpers\Json;
use app\models\DeviceInfo;
use yii\helpers\ArrayHelper;
use app\models\ViewTemplate;
use Yii;

class TemplateController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $lists = DeviceInfo::getSelect2List(ViewTemplate::TYPE_BUILD);
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_BUILD);
       // $lists = ArrayHelper::map($lists,'id','text');
        return $this->render('editor',["lists"=>$lists,"selected"=>Json::encode($selected, JSON_FORCE_OBJECT),"type"=>ViewTemplate::TYPE_BUILD]);
    }

    public function actionAjaxItems($q=null){
        $data = DeviceInfo::getSelect2List(null,$q,[]);
        return Json::encode(["results"=>$data]);
    }

    /**
     * 保存模板
     */
    public function actionSave(){
        $type = Yii::$app->request->post("type",0);
        $data = Yii::$app->request->post("data");
        $result = ["status"=> 0,'msg'=>''];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            ViewTemplate::deleteAll(["type"=>$type]);
            $data = json_decode($data,true);
            foreach($data as $k=>$item){
                $model = new ViewTemplate();
                $model->id = $k;
                $model->attributes = json_encode($item["attributes"]);
                $model->links = isset($item["links"])? json_encode($item["links"]):null;
                $model->type = $type;
                $model->device_id = $item["data"]["id"];
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
}
