<?php

namespace app\input\controllers;

use yii\data\ArrayDataProvider;
use frontend\models\RestfulClient;
use yii\helpers\Json;

class ConfigSetController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $url = $this->getApiUrl('/res/access/ipMacBind');

        $data = [];

        $client = (new RestfulClient())->get($url);
        if(!$client->hasErrors()){
            $data = $client->getData();
        }

        // TODO接口取数据
       /* $data = [
            [
                "ip" => "10.6.251.21",
                "mac" => '00:0f:e2:66:db:2d',
                "status" => '正常',
                "id" => 1
            ],
            [
                "ip" => "10.6.251.52",
                "mac" => '00:0f:e2:62:cb:4d',
                "status" => '正常',
                "id" => 2
            ]

        ];*/
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);

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
        }else{
            $this->redirect('index');
        }

    }

    public function actionSend(){
        $url = $this->getApiUrl('/res/access/ipMacBind');

        $client = (new RestfulClient())->post($url,\Yii::$app->request->post());
        if($client->hasErrors()){
            echo '<script>alert("操作失败")</script>';
            \Yii::$app->end();
        }else{
            $this->redirect('index');
        }
    }

    private function getApiUrl($path){
        $domain = rtrim(\Yii::$app->params["api_host"],'/');
        return $domain.'/'.trim($path,'/');
    }
}
