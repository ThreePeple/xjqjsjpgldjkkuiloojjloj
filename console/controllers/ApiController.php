<?php

namespace console\controllers;
use frontend\models\Constants;
use yii\console\Controller;
use yii\log\Logger;
use yii\base\Exception;
use Yii;
use yii\helpers\Json;
use frontend\models\RestfulClient;

class ApiController extends Controller
{
    public function actionIndex()
    {
        echo '11';
    }

    /**
     * 无线设备相关资源任务
     */
    public function actionWirelessDeviceSourceTask()
    {
       $host=Yii::$app->params['wireless_api_host'];
       $api_path=Constants::WIRELESS_DEVICE;
       $query=['resPrivilegeFilter=false&start=0&size=500&orderBy=id&desc=false&total=false'];
        //设备信息列表
        $url=$host.$api_path;
       $client=(new RestfulClient())->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            var_dump($data);
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/actionWirelessDeviceSourceTask');
        }
    }
}
