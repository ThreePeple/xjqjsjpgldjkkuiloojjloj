<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/9/3
 * Time: 22:31
 */

namespace console\controllers;


use app\models\WirelessDeviceAlarm;
use common\models\User;
use frontend\models\DeviceAlarm;
use frontend\models\SmsConfig;
use frontend\models\SmsList;
use frontend\models\SmsTemplate;
use yii\console\Controller;
use Yii;

class SmsController extends Controller{

    /**
     * 扫描告警列表插入消息队列
     */
    public function actionAlarmFind(){
        $configs = SmsConfig::find()->all();
        foreach($configs as $config){
            $phones =implode(',',array_filter($this->getPhoneNum($config->receivers)));
            if(empty($phones))
                continue;
            $condition =$config->alarmCondition;
            $time = strtotime('-1 hour');
            $ips = null;
            if($config->sms_device_type ==0){
                $query = DeviceAlarm::find();
            }else{
                $query = WirelessDeviceAlarm::find();
            }
            if(!empty($config->dev_ips)){
                $ips = explode(',',$config->dev_ips);
            }
            $alarms = $query->where(['and','faultTime>='.$time,'recStatus=0'])
                ->andWhere($condition)
                ->andFilterWhere(['deviceIp',$ips])
                ->select(SmsTemplate::$template_fields)
                ->asArray()
                ->all();

            $template = $this->getTemplate($config->smsTemplate_id);
            foreach($alarms as $alarm){
                $model = new SmsList();
                $model->receivers = $phones;
                $model->content = strtr($template,$alarm);
                if(!$model->save()){
                    Yii::error(print_r($model->getErrors(),true),'sms/find');
                }
            }
        }
    }

    public function actionAlarmFindBak(){
        $configs = SmsConfig::find()->all();

        foreach($configs as $config){
            $LastId = Yii::$app->cache->get("config_last_id_".$config->id);
            if(!$LastId)
                $LastId = 0;

            $phones =implode(',',array_filter($this->getPhoneNum($config->receivers)));
            if(empty($phones))
                continue;
            $condition =$config->alarmCondition;
            $alarms = DeviceAlarm::find()
                ->where(['and','serial_num > '.$LastId,'faultTime>='.strtotime($config->update_time)])
                ->andWhere($condition)
                ->select(array_merge(SmsTemplate::$template_fields,["serial_num"=>"serial_num"]))
                ->asArray()
                ->all();

            $template = $this->getTemplate($config->smsTemplate_id);
            foreach($alarms as $alarm){
                $model = new SmsList();
                $model->receivers = $phones;
                $model->content = strtr($template,$alarm);
                if(!$model->save()){
                    Yii::error(print_r($model->getErrors(),true),'sms/find');
                }
                if($alarm["serial_num"]>$LastId){
                    $LastId = $alarm["serial_num"];
                }
            }
            Yii::$app->cache->set("config_last_id_".$config->id,$LastId);
        }
    }

    /**
     * 消息队列发送
     */
    public function actionSend(){
        $lists = SmsList::find()->where(["status"=>0])->all();
        $wsdl = Yii::$app->params["sms_soap"];
        $soapClient = new \SoapClient($wsdl);
        $soapClient->soap_defencoding = 'utf-8';
        $soapClient->decode_utf8 = false;
        $soapClient->xml_encoding = 'utf-8';
        foreach($lists as $sms){
            $r = $soapClient->__soapCall('SendSMS',[
                'SendSMS' =>[
                    'telList' => $sms->receivers,
                    'content' => $sms->content
                ]
            ]);
            /*
            $sms->send_times = $sms->send_times+1;
            $sms->status = (int)$r->SendSMSResult;
            if($sms->send_times>5 && $sms->status==0){
                //发送超过5次 失败的设置为失败状态 不在尝试发送
                $sms->status= 2;
            }
            $sms->save(false);
            */
            $sms->delete();
        }
    }

    private function getPhoneNum($ids){
        $data = User::find()->where(["id"=>explode(',',$ids)])
            ->select("phone")
            ->asArray()
            ->column();
        array_walk($data,function(&$val){
            $val = str_replace('-','',$val);
        });
        return $data;
    }

    private function getTemplate($template_id){
        return SmsTemplate::find()->where(["id"=>$template_id])
            ->select("content")
            ->scalar();
    }
}