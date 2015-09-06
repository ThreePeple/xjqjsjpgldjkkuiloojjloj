<?php

namespace app\input\controllers;

use frontend\models\AccessDeviceInfo;
use Yii;
use frontend\models\AccessDeviceInfoSearch;
use yii\data\ArrayDataProvider;
use frontend\models\RestfulClient;
use yii\helpers\Json;

class ConfigSetController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        /*
        $url = $this->getApiUrl('/res/access/ipMacBind');

        $data = [];

        $client = (new RestfulClient())->get($url);
        if(!$client->hasErrors()){
            $data = $client->getData();
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        */
        $model = new AccessDeviceInfoSearch();
        $dataProvider = $model->search(Yii::$app->request->queryParams);
        return $this->render("index",[
            'dataProvider'=>$dataProvider,
        ]);
    }

    public function actionDelete($id){
        $id = \Yii::$app->request->get("id");
        $url = $this->getApiUrl('/res/access/ipMacBind/'.$id);

        $client = (new RestfulClient())->request('DELETE',$url);

        if($client->hasErrors()){
            echo '<script>alert("操作失败")</script>';
            \Yii::$app->end();

        }else{
            $this->redirect('index');
        }

    }

    public function actionBind(){
        $result = $this->bind(Yii::$app->request->get('ip'),Yii::$app->request->get("mac"),Yii::$app->request->get
        ('id'));
        if($result){
            echo '<script>alert("操作失败")</script>';
            \Yii::$app->end();
        }else{
            $this->redirect('index');
        }
    }
    public function actionBatchBind(){
        $ids = Yii::$app->request->post('ids');
        $rows = AccessDeviceInfo::find()->where(['id'=>explode(',',$ids)])->select(["ip"=>'learnIp',
            'mac'=>'learnMac','id'])
            ->asArray()->all();
        foreach($rows as $row){
            $this->bind($row["ip"],$row["mac"],$row['id']);
        }
        $this->redirect('index');
    }

    public function actionUnbind(){
        $result = $this->unBind(Yii::$app->request->get('id'));
        if($result){
            echo '<script>alert("操作失败")</script>';
            \Yii::$app->end();
        }else{
            $this->redirect('index');
        }
    }

    public function actionBatchUnbind(){
        $ids = Yii::$app->request->post('ids');
        $ids = explode(',',$ids);
        foreach($ids as $id){
            $this->unBind($id);
        }
        $this->redirect('index');
    }

    /**
     * 绑定
     * @param $ip
     * @param $mac
     */
    private function bind($ip,$mac,$id){
        $url = $this->getApiUrl('/res/access/ipMacBind');

        $client = (new RestfulClient())->post($url,\Yii::$app->request->get());

        $result = !$client->hasErrors();

        if($result){
            $bindId = 0; //获取绑定ID TODO
            //下入绑定ID 更新状态
            AccessDeviceInfo::updateAll(['status'=>1,"bindId"=>$bindId],["id"=>$id]);
        }

        return $result;
    }

    private function unBind($id){
        $url = $this->getApiUrl('/res/access/ipMacBind');

        $url .= '/'.$id;

        $client = (new RestfulClient())->request('DELETE',$url);

        return !$client->hasErrors();

    }


    private function getApiUrl($path){
        $domain = rtrim(\Yii::$app->params["api_host"],'/');
        return $domain.'/'.trim($path,'/');
    }
}
