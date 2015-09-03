<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/9/3
 * Time: 22:31
 */

namespace console\controllers;


use app\models\DeviceAlarm;
use frontend\models\SmsConfig;
use yii\console\Controller;
use Yii;

class SmsController extends Controller{

    /**
     * 扫描告警列表插入消息队列
     */
    public function actionAlarmFind(){
        $configs = SmsConfig::find()->all();
        $LastId = Yii::$app->cache->get("last_alarm_serialNum");
        foreach($configs as $config){
            $condition =$config->alarmCondition;

            $alarms = DeviceAlarm::find()
                ->where(['and','serial_num > '.$LastId,'faultTime>='.strtotime($config->update_time)])
                ->andWhere($condition)
                ->all();
            var_dump($alarms);

        }
    }
}