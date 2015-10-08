<?php

namespace console\controllers;
use frontend\models\Constants;
use yii\console\Controller;
use frontend\models\DeviceCategoryMap;
use frontend\models\DeviceSeries;
use frontend\models\DeviceModel;
use frontend\models\AccessDeviceInfo;
use frontend\models\DeviceInfo;
use frontend\models\WirelessDeviceInfo;
use yii\log\Logger;
use yii\base\Exception;
use Yii;
use yii\helpers\Json;
use frontend\models\RestfulClient;
use common\models\helpers;

class ApiController extends Controller
{
    public function actionIndex()
    {
        $ip='10.6.253.52';
        $area=helpers::getAreaByIpRules($ip);
        echo $area;
    }

    /**
     * 设备型号
     */
    public function actionDeviceModel()
    {
        $host=Yii::$app->params['api_host'];
        //无线设备数据
        $api_path=Constants::DEVICE_MODEL;
        $url=$host.$api_path;
        $start=0;
        for($i=0;$i<20;$i++)
        {
            $query=[
                'start'=>$start,
                'size'=>500,
                'orderBy'=>'id',
                'desc'=>false,
                'total'=>false,
            ];
            $client=(new RestfulClient("http_imc"))->get($url,$query);
            if(!$client->hasErrors())
            {
                $data = $client->getData();
                if(empty($data['deviceModel']))
                {
                    break;
                }
                foreach($data['deviceModel'] as $_data)
                {
                    if($this->importDeviceModel($_data))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['id']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceModel');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['id']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceModel');
                        break;
                    }
                }
            }
            else
            {
                var_dump($client->getErrorCode());
                Yii::error($client->getError(),'console/actionDeviceModel');
                break;
            }
            $start+=500;
        }
    }
    /**
 * 无线设备相关资源任务
 */
    public function actionWirelessDeviceSourceTask()
    {
        $host=Yii::$app->params['wireless_api_host'];
        //无线设备数据
        $api_path=Constants::DEVICE;
        $query=[
            'resPrivilegeFilter'=>false,
            'start'=>0,
            'orderBy'=>'id',
            'desc'=>false,
            'size'=>500,
            'total'=>false,
        ];
        //设备信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient("http_basic"))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            // var_dump($data['device']);die;
            if(isset($data['device']))
            {
                foreach($data['device'] as $_data)
                {
                    $_param=$this->getDeviceDetail($_data['id']);
                   // var_dump($_param);die;
                    if($this->importWirelessDevice($_param))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceSourceTask');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceSourceTask');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
           // var_dump($client->getError());
            Yii::error($client->getError(),'console/actionWirelessDeviceSourceTask');
        }
    }
    /**
     * 无线设备更新状态
     */
    public function actionWirelessDeviceStatusTask()
    {
        $host=Yii::$app->params['wireless_api_host'];
        //无线设备数据
        $api_path=Constants::DEVICE;
        $query=[
            'resPrivilegeFilter'=>false,
            'start'=>0,
            'orderBy'=>'id',
            'desc'=>false,
            'size'=>500,
            'total'=>false,
        ];
        //设备信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient("http_basic"))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            // var_dump($data['device']);die;
            if(isset($data['device']))
            {
                foreach($data['device'] as $_data)
                {
                    if($this->updateDeviceStatus($_data))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." update status ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceStatusTask');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." update status fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceStatusTask');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
            Yii::error($client->getError(),'console/actionWirelessDeviceStatusTask');
        }
    }
    /**
 * 有线设备相关资源任务
 */
    public function actionDeviceSourceTask()
    {
        $host=Yii::$app->params['api_host'];
        //有线设备数据
        $api_path=Constants::DEVICE;
        $query=[
            'resPrivilegeFilter'=>false,
            'start'=>0,
            'orderBy'=>'id',
            'desc'=>false,
            'size'=>500,
            'total'=>false,
        ];
        //设备信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient("http_imc"))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            // var_dump($data['device']);
            if(isset($data['device']))
            {
                foreach($data['device'] as $_data)
                {
                    $_param=$this->getDeviceDetail($_data['id'],'api_host');
                    if($this->importDevice($_param))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceSourceTask');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceSourceTask');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
            Yii::error($client->getError(),'console/actionDeviceSourceTask');
        }
    }
    /**
     * 有线设备更新状态
     */
    public function actionDeviceStatusTask()
    {
        $host=Yii::$app->params['api_host'];
        //无线设备数据
        $api_path=Constants::DEVICE;
        $query=[
            'resPrivilegeFilter'=>false,
            'start'=>0,
            'orderBy'=>'id',
            'desc'=>false,
            'size'=>500,
            'total'=>false,
        ];
        //设备信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient("http_imc"))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            // var_dump($data['device']);
            if(isset($data['device']))
            {
                foreach($data['device'] as $_data)
                {
                    if($this->updateDeviceStatus($_data,"device_info"))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." update status ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceStatusTask');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['ip']." update status fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceStatusTask');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
            Yii::error($client->getErrorCode(),'console/actionDeviceStatusTask');
        }
    }
    /**
     * 查询当前接入设备
     */
    public function actionIpmaclearn()
    {
        $host=Yii::$app->params['api_host'];
        $api_path=Constants::IP_MAC_LEARN;
        $url=$host.$api_path."/";
        echo $url;
        $query=[
            'start'=>0,
            'desc'=>false,
            'size'=>500,
            'total'=>false,
        ];
        $devices=$this->getDevices();
        if(empty($devices))
        {
            echo "找不到对应设备/n";
            exit;
        }
        foreach($devices as $device)
        {
            $url=$url.$device['id'];
            $client=(new RestfulClient("http_imc"))->get($url,$query);
            if(!$client->hasErrors())
            {
                $data = $client->getData();
                // var_dump($data);
                if(isset($data['ipMacLearnResult']))
                {
                    foreach($data['ipMacLearnResult'] as $_data)
                    {
                        if($this->importIpMacLearn($_data))
                        {
                            $info=date('y-m-dh:i:s',time()).":".$_data['learnIp']." import ok\n";
                            echo $info;
                            Yii::info($info,'console_track/actionIpmaclearn');
                        }
                        else
                        {
                            $info=date('y-m-dh:i:s',time()).":".$_data['learnIp']." import fail\n";
                            echo $info;
                            Yii::info($info,'console_track/actionIpmaclearn');
                            break;
                        }
                    }
                }
            }
            else
            {
                var_dump($client->getErrorCode());
                Yii::error($client->getErrorCode(),'console/actionIpmaclearn');
            }
        }
    }

    /**
     * 无线设备链路数据
     */
    public function actionWirelessDeviceLink()
    {
        $host=Yii::$app->params['wireless_api_host'];
        //无线设备数据
        $api_path=Constants::DEVICE_LINK;
        $query=[
            'topoId'=>1,
            'total'=>false,
        ];
        //设备链路信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient("http_basic"))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            if(isset($data['deviceLink']))
            {
                foreach($data['deviceLink'] as $_data)
                {
                    if($this->importDeviceLink($_data))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['id']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceLink');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['id']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceLink');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
            Yii::error($client->getErrorCode(),'console/actionWirelessDeviceLink');
        }
    }
    /**
     * 有线设备链路数据
     */
    public function actionDeviceLink()
    {
        $host=Yii::$app->params['api_host'];
        //无线设备数据
        $api_path=Constants::DEVICE_LINK;
        $query=[
            'topoId'=>1,
            'total'=>false,
        ];
        //设备链路信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient("http_imc"))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            // var_dump($data['deviceLink']);
            if(isset($data['deviceLink']))
            {
                foreach($data['deviceLink'] as $_data)
                {
                    if($this->importDeviceLink($_data,"device_link"))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['id']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceLink');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['id']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceLink');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
            Yii::error($client->getErrorCode(),'console/actionDeviceLink');
        }
    }

    /**
     * 性能指标基础信息
     */
    public function actionTask()
    {
        $host=Yii::$app->params['wireless_api_host'];
        $api_path=Constants::TASK;
       /* $query=[
            'orderBy'=>'taskId',
            'desc'=>false,
        ];*/
        $url=$host.$api_path;
        echo $url."\n";
        $client=(new RestfulClient("http_basic"))->get($url);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            if(isset($data['task']))
            {
                foreach($data['task'] as $_data)
                {
                    if($this->importTask($_data))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['taskId']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionTask');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['taskId']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionTask');
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getErrorCode());
            Yii::error($client->getErrorCode(),'console/actionTask');
        }
    }
    /**
     * 无线设备性能指标汇总信息
     */
    public function actionWirelessDeviceTask()
    {
        //获取无线设备
        $devices=$this->getWirelessDevices();
        //指标配置项
        $task_ids=Constants::$TASKS;
        $host=Yii::$app->params['wireless_api_host'];
        $api_path=Constants::DEVICE_TASK;
        $url=$host.$api_path;
        echo $url."\n";
        if(empty($devices))
        {
           echo " devices are not found!";
            exit;
        }
        //遍历所有设备和指定指标项
        foreach($devices as $device)
        {
            $device_id=$device['id'];
            foreach($task_ids as $task_id)
            {

                $query=[
                    'taskId'=>$task_id,
                    'devId'=>$device_id,
                    'dataGranularity'=>1
                ];
                $client=(new RestfulClient("http_basic"))->get($url,$query);
                if(!$client->hasErrors())
                {
                    $data = $client->getData();
                    if(isset($data['perfSummaryData']))
                    {
                        $_data=$data['perfSummaryData'];
                        if(isset($data['perfSummaryData'][0]))
                        {

                            foreach ($_data as $_param ) {
                                if($this->importDeviceTask($_param))
                                {
                                    //sleep(0.5);
                                    $info=date('y-m-dh:i:s',time()).":".$_param['devId']."&".$_param['taskId']." import ok\n";
                                    echo $info;
                                    Yii::info($info,'console_track/actionWirelessDeviceTask');
                                }
                                else
                                {
                                    $info=date('y-m-dh:i:s',time()).":".$_param['devId']."&".$_param['taskId']." import fail\n";
                                    echo $info;
                                    Yii::info($info,'console_track/actionWirelessDeviceTask');
                                    break;
                                }
                            }
                        }
                        else
                        {
                            if($this->importDeviceTask($_data))
                            {
                                //sleep(0.5);
                                $info=date('y-m-dh:i:s',time()).":".$_data['devId']."&".$_data['taskId']." import ok\n";
                                echo $info;
                                Yii::info($info,'console_track/actionWirelessDeviceTask');
                            }
                            else
                            {
                                $info=date('y-m-dh:i:s',time()).":".$_data['devId']."&".$_data['taskId']." import fail\n";
                                echo $info;
                                Yii::info($info,'console_track/actionWirelessDeviceTask');
                                break;
                            }
                        }
                    }
                }
                else
                {
                    var_dump($client->getErrorCode());
                    Yii::error($client->getErrorCode(),'console/actionWirelessDeviceTask');
                }
            }
        }
    }
    /**
     * 有线设备性能指标汇总信息
     */
    public function actionDeviceTask()
    {
        //获取无线设备
        $devices=$this->getDevices();
        //指标配置项
        $task_ids=Constants::$TASKS;
        $host=Yii::$app->params['api_host'];
        $api_path=Constants::DEVICE_TASK;
        $url=$host.$api_path;
        echo $url."\n";
        if(empty($devices))
        {
            echo " devices are not found!";
            exit;
        }
        //遍历所有设备和指定指标项
        foreach($devices as $device)
        {
            $device_id=$device['id'];
            foreach($task_ids as $task_id)
            {
                $query=[
                    'taskId'=>$task_id,
                    'devId'=>$device_id,
                    'dataGranularity'=>1
                ];
                $client=(new RestfulClient("http_imc"))->get($url,$query);
                if(!$client->hasErrors())
                {
                    $data = $client->getData();
                    if(isset($data['perfSummaryData']))
                    {
                        $_data=$data['perfSummaryData'];
                        if(isset($data['perfSummaryData'][0]))
                        {

                            foreach ($_data as $_param ) {
                                if($this->importDeviceTask($_param))
                                {
                                    $info=date('y-m-dh:i:s',time()).":". $_param['devId']."&".$_param['taskId']." import ok\n";
                                    echo $info;
                                    Yii::info($info,'console_track/actionDeviceTask');
                                }
                                else
                                {
                                    $info=date('y-m-dh:i:s',time()).":". $_param['devId']."&".$_param['taskId']." import fail\n";
                                    echo $info;
                                    Yii::info($info,'console_track/actionDeviceTask');
                                    break;
                                }
                            }
                        }
                        else
                        {
                            if($this->importDeviceTask($_data))
                            {
                                $info=date('y-m-dh:i:s',time()).":". $_param['devId']."&".$_param['taskId']." import ok\n";
                                echo $info;
                                Yii::info($info,'console_track/actionDeviceTask');
                            }
                            else
                            {
                                $info=date('y-m-dh:i:s',time()).":". $_param['devId']."&".$_param['taskId']." import fail\n";
                                echo $info;
                                Yii::info($info,'console_track/actionDeviceTask');
                                break;
                            }
                        }
                        //$_data=isset($data['perfSummaryData'][0])?$data['perfSummaryData'][0]:[0=>$data['perfSummaryData']];

                    }
                }
                else
                {
                    var_dump($client->getErrorCode());
                    Yii::error($client->getErrorCode(),'console/actionDeviceTask');
                }
            }
        }
    }
    /**
     * 无线设备告警信息
     */
    public function actionWirelessDeviceAlarm()
    {
        //获取无线设备
        $alarms=$this->getDevicesAlarmList();
        $host=Yii::$app->params['wireless_api_host'];
        $api_path=Constants::DEVICE_ALARM;
        $url=$host.$api_path;
        if(empty($alarms))
        {
            echo " alarms are not found!";
            exit;
        }
        //遍历所有告警项
        foreach($alarms as $alarm)
        {
            $alarm_id=$alarm['id'];
            $_url=$url."/".$alarm_id;
            $client=(new RestfulClient("http_basic"))->get($_url);
            if(!$client->hasErrors())
            {
                $data = $client->getData();
                if(isset($data))
                {
                    $_data=$data;
                    if($this->importDeviceAlarm($_data))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['deviceIp']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceAlarm');
                    }
                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['deviceIp']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionWirelessDeviceAlarm');
                        break;
                    }
                }
            }
            else
            {
                var_dump($client->getErrorCode());
                Yii::error($client->getErrorCode(),'console/actionWirelessDeviceAlarm');
            }
        }
    }
    /**
     * 有线设备告警信息
     */
    public function actionDeviceAlarm()
    {
        //获取无线设备
        $alarms=$this->getDevicesAlarmList('device_alarm');
        $host=Yii::$app->params['api_host'];
        $api_path=Constants::DEVICE_ALARM;
        $url=$host.$api_path;
        //echo $url."\n";
        if(empty($alarms))
        {
            echo " alarms are not found!";
            exit;
        }
        //遍历所有告警项
        foreach($alarms as $alarm)
        {
            $alarm_id=$alarm['id'];
            $_url=$url."/".$alarm_id;
           // echo $_url."\n";
            $client=(new RestfulClient("http_imc"))->get($_url);
            if(!$client->hasErrors())
            {
                $data = $client->getData();
                if(isset($data))
                {
                    $_data=$data;
                    if($this->importDeviceAlarm($_data,'device_alarm'))
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['deviceIp']." import ok\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceAlarm');
                    }

                    else
                    {
                        $info=date('y-m-dh:i:s',time()).":".$_data['deviceIp']." import fail\n";
                        echo $info;
                        Yii::info($info,'console_track/actionDeviceAlarm');
                        break;
                    }
                }
            }
            else
            {
                var_dump($client->getErrorCode());
                Yii::error($client->getErrorCode(),'console/actionDeviceAlarm');
            }
        }
    }
    ///////////////////私有函数////////////////////////
    /**
     * 导入设备型号
     * @param $param
     * @return bool
     */
    private function importDeviceModel($param)
    {
        try
        {
            $sql="insert into `device_model`(id,`name`,description,sysOid,series_id,category_id,deviceVersion)";
            $sql.=" values(".$param['id'].",'".$param['name']."','".$param['description']."','".$param['sysOid']."',".$param['seriesId'].",".$param['categoryId'].",";
            $sql.="'".$param['deviceVersion']."') on duplicate key update " ;
            $sql.="`name`='".$param['name']."',description='".$param['description']."',sysOid='".$param['sysOid']."',series_id=".$param['seriesId'].",";
            $sql.="category_id=".$param['categoryId'].",deviceVersion='".$param['deviceVersion']."'";
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importDeviceModel');
            return false;
        }
    }
    /**
     * 获取设备明细数据
     * @param $device_id
     * @param string $host
     * @return array
     */
    private function getDeviceDetail($device_id,$host_flag='wireless_api_host')
    {
        if(empty($device_id))
        {
            return [];
        }
        $host=Yii::$app->params[$host_flag];
        $data=[];
        $api_path=Constants::DEVICE;
        $url=$host.$api_path."/".$device_id;
        $param_config=$host_flag=='wireless_api_host'?'http_basic':'http_imc';
        $client=(new RestfulClient($param_config))->get($url);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
        }
        else
        {
            var_dump($client->getErrorCode());
            return [];
        }
        return $data;
    }
    /**
     * 导入无线设备数据
     */
    private function importWirelessDevice($_data)
    {
        $param=$_data;
        try
        {
            //初始化
            $param=$this->initParams($param);
            //对原始数据进行特殊处理
            if(empty($param['ip']))
            {
                echo "can not get ip";
                return false;
            }
            //类型映射
            $map_id=$this->getDeviceMapCategoryID($param['ip']);
            $param['categoryId']=empty($map_id)?$param['categoryId']:$map_id;

            //echo '22'.$map_id;die;
            //处理设备系列
           // var_dump($param);die;
            if(isset($param['series']))
            {
                $series=$this->getDeviceSeries($param['series']);
                $param['series_id']=$series['series_id'];
                $param['series_name']=$series['series_name'];
            }
            else
            {
                $param['series_id']=0;
                $param['series_name']='';
            }
            //处理设备型号
            if(isset($param['model']))
            {
                $models=$this->getDeviceModel($param['model']);
                $param['model_id']=$models['model_id'];
                $param['model_name']=$models['model_name'];
            }
            else
            {
                $param['model_id']=0;
                $param['model_name']='';
            }
            $param['mac']=isset($param['mac'])?$param['mac']:'';



            $sql="insert into `wireless_device_info`(id,`label`,ip,mask,status,sysName,location,sysOid,categoryId";
            $sql.=",typeName,symbolType,symbolDesc,mac,statusDesc)";
            $sql.=" values(".$param['id'].",'".$param['label']."','".$param['ip']."','".$param['mask']."',".$param['status'].",'".$param['sysName']."',";
            $sql.="'".$param['location']."','".$param['sysOid']."',".$param['categoryId'].",'".$param['typeName']."',".$param['symbolType'];
            $sql.=",'".$param['symbolDesc']."','".$param['mac']."','".$param['statusDesc']."') on duplicate key update ";
            $sql.="id=".$param['id'].",label='".$param['label']."',mask='".$param['mask']."',status=".$param['status'].",sysName='".$param['sysName']."',";
            $sql.="location='".$param['location']."',sysOid='".$param['sysOid']."',categoryId=".$param['categoryId'];
            $sql.=",symbolType=".$param['symbolType'].",symbolDesc='".$param['symbolDesc']."',mac='".$param['mac']."',statusDesc='".$param['statusDesc']."'";
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importWirelessDevice');
            return false;
        }

    }
    /**
     * 导入设备数据
     */
    private function importDevice($_data)
    {
        $param=$_data;
        try
        {
            //初始化
            $param=$this->initParams($param);
            //对原始数据进行特殊处理
            if(empty($param['ip']))
            {
                echo "can not get ip";
                return false;
            }
            //类型映射
            $map_id=$this->getDeviceMapCategoryID($param['ip']);
            $param['categoryId']=empty($map_id)?$param['categoryId']:$map_id;

            //echo '22'.$map_id;die;
            //处理设备系列
            // var_dump($param);die;
            if(isset($param['series']))
            {
                $series=$this->getDeviceSeries($param['series']);
                $param['series_id']=$series['series_id'];
                $param['series_name']=$series['series_name'];
            }
            else
            {
                $param['series_id']=0;
                $param['series_name']='';
            }
            //处理设备型号
            if(isset($param['model']))
            {
                $models=$this->getDeviceModel($param['model']);
                $param['model_id']=$models['model_id'];
                $param['model_name']=$models['model_name'];
            }
            else
            {
                $param['model_id']=0;
                $param['model_name']='';
            }
            $param['mac']=isset($param['mac'])?$param['mac']:'';
            //根据IP规则转换区域
            $param['area']=helpers::getAreaByIpRules($param['ip']);

            $sql="insert into `device_info`(id,`label`,ip,mask,status,sysName,location,sysOid,categoryId";
            $sql.=",typeName,symbolType,symbolDesc,mac,statusDesc,series_id,series_name,model_id,model_name,area)";
            $sql.=" values(".$param['id'].",'".$param['label']."','".$param['ip']."','".$param['mask']."',".$param['status'].",'".$param['sysName']."',";
            $sql.="'".$param['location']."','".$param['sysOid']."',".$param['categoryId'].",'".$param['typeName']."',".$param['symbolType'];
            $sql.=",'".$param['symbolDesc']."','".$param['mac']."','".$param['statusDesc']."',".$param['series_id'].",'".$param['series_name']."',".$param['model_id'].",'".$param['model_name']."','".$param['area']."'";
            $sql.=") on duplicate key update ";
            $sql.="id=".$param['id'].",label='".$param['label']."',mask='".$param['mask']."',status=".$param['status'].",sysName='".$param['sysName']."',";
            $sql.="location='".$param['location']."',sysOid='".$param['sysOid']."',categoryId=".$param['categoryId'];
            $sql.=",symbolType=".$param['symbolType'].",symbolDesc='".$param['symbolDesc']."',mac='".$param['mac']."',statusDesc='".$param['statusDesc']."'";
            $sql.=",model_id=".$param['model_id'].",model_name='".$param['model_name']."',series_id=".$param['series_id'].",series_name='".$param['series_name']."',area='".$param['area']."'";
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importDevice');
            return false;
        }

    }
    /**
     * 更新设备状态
     */
    private function updateDeviceStatus($param,$tableName='wireless_device_info')
    {
        if(empty($param))
        {
            return true;
        }
        try
        {
            $sql=" update `".$tableName."` set status=".$param['status']." where ip='".$param['ip']."'";
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/updateDeviceStatus');
            return false;
        }

    }
    /**
     * 得到设备映射的类型ID
     */
    private function getDeviceMapCategoryID($ip)
    {
        $map=DeviceCategoryMap::find()->where(['ip'=>$ip])->one();
        return empty($map)?0:$map['categoryId'];
    }

    /**
     * 提取设备系列id，并得到系列名称
     */
    private function getDeviceSeries($series_url)
    {
        $result=['series_id'=>0,'series_name'=>''];
        if(!empty($series_url))
        {
            $pos=strripos($series_url,'/');
            $series_id=substr($series_url,$pos+1);
            $result['series_id']=$series_id;
            if(!empty($series_id))
            {
                $series=DeviceSeries::findOne($series_id);
                if(!empty($series))
                {
                    $result['series_name']=$series['name'];
                }
            }
        }
        return $result;
    }
    /**
     * 提取设备型号id，并得到型号名称
     */
    private function getDeviceModel($model_url)
    {
        $result=['model_id'=>0,'model_name'=>''];
        if(!empty($model_url))
        {
            $pos=strripos($model_url,'/');
            $model_id=substr($model_url,$pos+1);
            $result['model_id']=$model_id;
            if(!empty($model_id))
            {
                $models=DeviceModel::findOne($model_id);
                if(!empty($models))
                {
                    $result['model_name']=$models['name'];
                }
            }
        }
        return $result;

    }
    /**
     * 提取设备URL中的id
     */
    private function getDeviceUrlID($device_url)
    {
        $device_id=0;
        if(!empty($device_url))
        {
            $pos=strripos($device_url,'/');
            $device_id=substr($device_url,$pos+1);
        }
        return $device_id;
    }
    /**
     * 初始化字段
     * @param $_param
     * @return mixed
     */
    private function initParams($_param)
    {
        $param=$_param;
        if(!isset($_param['runtime']))
        {
            $param['runtime']='';
        }
        if(!isset($_param['lastPoll']))
        {
            $param['lastPoll']='';
        }
        if(!isset($_param['supportPing']))
        {
            $param['supportPing']=0;
        }
        if(!isset($_param['webMgrPort']))
        {
            $param['webMgrPort']=0;
        }
        if(!isset($_param['configPollTime']))
        {
            $param['configPollTime']=0;
        }
        if(!isset($_param['statePollTime']))
        {
            $param['statePollTime']=0;
        }
        if(!isset($_param['phyName']))
        {
            $param['phyName']='';
        }
        if(!isset($_param['phyCreateTime']))
        {
            $param['phyCreateTime']='';
        }
        return $param;
    }

    /**
     * 从表中获取有线设备信息
     */
    private function getDevices($ipAry=array())
    {
        $query=DeviceInfo::find();
        if(!empty($ipAry))
        {
            $query->where(['ip'=>$ipAry]);
        }
        return $query->all();
    }
    /**
     * 从表中获取无线设备信息
     */
    private function getWirelessDevices($ipAry=array())
    {
        $query=WirelessDeviceInfo::find();
        if(!empty($ipAry))
        {
            $query->where(['ip'=>$ipAry]);
        }
        return $query->all();
    }

    /**
     * @param $deviceId 设备ID
     */
    private function importIpMacLearn($param)
    {
        try
        {
            $sql="insert into `access_device_info`(deviceId,`deviceIp`,ifIndex,ifDesc,vlanId,learnIp,learnMac,status)";
            $sql.=" values(".$param['deviceId'].",'".$param['deviceIp']."',".$param['ifIndex'].",'".$param['ifDesc']."',".$param['vlanId'].",";
            $sql.="'".$param['learnIp']."','".$param['learnMac']."',0) on duplicate key update ";
            $sql.="ifIndex=".$param['ifIndex'].",ifDesc='".$param['ifDesc']."',vlanId=".$param['vlanId'];
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importWirelessDevice');
            return false;
        }
    }
    /**
     * 导入设备链路数据
     * 通过列表接口获取链路ID，再通过单条数据接口通过id获取左右设备id
     */
    private function importDeviceLink($_data,$tableName="wireless_device_link")
    {
        $param=[];
        if(empty($_data) || !isset($_data['id']))
        {
            return false;
        }
        try
        {
            //根据列表的ID,获取详细信息
            $host =$tableName=="wireless_device_link"?Yii::$app->params['wireless_api_host']:Yii::$app->params['api_host'];
            //无线设备数据
            $api_path=Constants::DEVICE_LINK;
            $query=[
                'topoId'=>1
            ];
            //设备链路信息
            $url=$host.$api_path."/".$_data['id'];
            $authkey=$tableName=="wireless_device_link"?"http_basic":"http_imc";
            $client=(new RestfulClient($authkey))->get($url,$query);
            if(!$client->hasErrors())
            {
                $data = $client->getData();
                //var_dump($data);
                if(isset($data))
                {
                    $param=$data;
                }
            }
            else
            {
                var_dump($client->getError());
                Yii::error($client->getError(),'console/actionDeviceLink');
                return false;
            }
            if(isset($param['leftDevice']))
            {
                $leftDevice_id=$this->getDeviceUrlID($param['leftDevice']);
                $param['leftDevice']=$leftDevice_id;
            }
            else
            {
                $param['leftDevice']=0;
            }
            if(isset($param['rightDevice']))
            {
                $rightDevice_id=$this->getDeviceUrlID($param['rightDevice']);
                $param['rightDevice']=$rightDevice_id;
            }
            else
            {
                $param['rightDevice']=0;
            }
            if(!isset($param['leftSymbolName']))
            {
                $param['leftSymbolName']='';
            }
            if(!isset($param['rightSymbolName']))
            {
                $param['rightSymbolName']='';
            }
            $sql="insert into `".$tableName."`(id,`label`,`type`,leftSymbolId,leftSymbolName,leftIfDesc,rightSymbolId,rightSymbolName,";
            $sql.="rightIfDesc,status,bandWidth,leftDevice,rightDevice)";
            $sql.=" values(".$param['id'].",'".$param['label']."',".$param['type'].",".$param['leftSymbolId'].",'".$param['leftSymbolName']."','".$param['leftIfDesc']."',";
            $sql.=$param['rightSymbolId'].",'".$param['rightSymbolName']."','".$param['rightIfDesc']."',".$param['status'].",'".$param['bandWidth']."',";
            $sql.=$param['leftDevice'].",".$param['rightDevice'].") on duplicate key update ";
            $sql.="label='".$param['label']."',`type`=".$param['type'].",leftSymbolId=".$param['leftSymbolId'].",leftSymbolName='".$param['leftSymbolName']."',";
            $sql.="leftIfDesc='".$param['leftIfDesc']."',rightSymbolId=".$param['rightSymbolId'].",rightSymbolName='".$param['rightSymbolName']."'";
            $sql.=",rightIfDesc='".$param['rightIfDesc']."',status=".$param['status'].",bandWidth='".$param['bandWidth']."',leftDevice=".$param['leftDevice'];
            $sql.=",rightDevice=".$param['rightDevice'];
            $cmd = Yii::$app->db->createCommand($sql);
          //var_dump($sql);die;
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/imporDeviceLink');
            return false;
        }
    }

    /**
     * 导入性能指标
     * @param $param
     * @return bool
     */
    private function importTask($param)
    {
        try
        {
            $sql="insert into `task`(taskId,`taskName`,taskDescr,tempId,alarmOneThresholdFirst,alarmOneThresholdSecond,alarmTwoTimes,componentID,";
            $sql.="unitId,sumId,groupId)";
            $sql.=" values(".$param['taskId'].",'".$param['taskName']."','".$param['taskDescr']."','".$param['tempId']."',".$param['alarmOneThresholdFirst'].",";
            $sql.=$param['alarmOneThresholdSecond'].",".$param['alarmTwoTimes'].",".$param['componentID'].",".$param['unitId'].",".$param['sumId'].",".$param['groupId'];
            $sql.=") on duplicate key update ";
            $sql.="taskName='".$param['taskName']."',taskDescr='".$param['taskDescr']."',tempId='".$param['tempId']."',";
            $sql.="alarmOneThresholdFirst=".$param['alarmOneThresholdFirst'].",alarmOneThresholdSecond=".$param['alarmOneThresholdSecond'].",";
            $sql.="alarmTwoTimes=".$param['alarmTwoTimes'].",componentID=".$param['componentID'].",unitId=".$param['unitId'].",";
            $sql.="sumId=".$param['sumId'].",groupId=".$param['groupId'];
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importTask');
            return false;
        }
    }

    /**
     * 导入设备性能指标
     * @param $param 数据参数
     * @param string $tableName 无线和有线的标记
     * @return bool
     */
    private function importDeviceTask($param,$tableName='wireless_device_task_summary')
    {
        try
        {
            $param['averageValue']=isset($param['averageValue'])?$param['averageValue']:'0';
            $param['maximumValue']=isset($param['maximumValue'])?$param['maximumValue']:'0';
            $param['minimumValue']=isset($param['minimumValue'])?$param['minimumValue']:'0';
            $param['currentValue']=isset($param['currentValue'])?$param['currentValue']:'0';
            $param['summaryValue']=isset($param['summaryValue'])?$param['summaryValue']:'0';

            $sql="insert into ".$tableName." (taskId,`taskName`,devId,instId,objIndex,objIndexDesc,averageValue,maximumValue,minimumValue,";
            $sql.="currentValue,summaryValue)";
            $sql.=" values(".$param['taskId'].",'".$param['taskName']."',".$param['devId'].",".$param['instId'].",'".$param['objIndex']."',";
            $sql.="'".$param['objIndexDesc']."','".$param['averageValue']."','".$param['maximumValue']."','".$param['minimumValue']."',";
            $sql.="'".$param['currentValue']."','".$param['summaryValue']."'";
            $sql.=") on duplicate key update ";
            $sql.="instId=".$param['instId'].",objIndex='".$param['objIndex']."',objIndexDesc='".$param['objIndexDesc']."',";
            $sql.="averageValue='".$param['averageValue']."',maximumValue='".$param['maximumValue']."',";
            $sql.="minimumValue='".$param['minimumValue']."',currentValue='".$param['currentValue']."',summaryValue='".$param['summaryValue']."'";
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importTask');
            return false;
        }
    }

    /**
     * 获取告警列表
     */
    private function getDevicesAlarmList($tableName="wireless_device_alarm")
    {
        $param=[];
        $host =$tableName=="wireless_device_alarm"?Yii::$app->params['wireless_api_host']:Yii::$app->params['api_host'];
        $api_path=Constants::DEVICE_ALARM;
        $query=[
            'operatorName'=>'admin',
            'desc'=>false
        ];
        $url=$host.$api_path;
        $authkey=$tableName=="wireless_device_alarm"?"http_basic":"http_imc";
        $client=(new RestfulClient($authkey))->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            if(isset($data['alarm']))
            {
                $param=$data['alarm'];
            }
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/getDevicesAlarmList');
            return [];
        }
        return $param;
    }

    /**
     * 导入设备告警
     * @param $param
     * @param string $tableName
     */
    private function importDeviceAlarm($param,$tableName='wireless_device_alarm')
    {
        try
        {
            $sql="replace into ".$tableName." (id,`OID`,originalTypeDesc,deviceId,deviceIp,deviceName,alarmLevel,alarmLevelDesc,alarmCategory,alarmCategoryDesc,";
            $sql.="faultTime,faultTimeDesc,recTime,recTimeDesc,recStatus,recStatusDesc,ackUserName,alarmDesc,somState,remark,eventName,";
            $sql.="reason,defineType,customAlarmLevel,specificId,originalType)";
            $sql.=" values(".$param['id'].",'".$param['OID']."','".$param['originalTypeDesc']."',".$param['deviceId'].",'".$param['deviceIp']."',";
            $sql.="'".$param['deviceName']."',".$param['alarmLevel'].",'".$param['alarmLevelDesc']."',".$param['alarmCategory'].",";
            $sql.="'".$param['alarmCategoryDesc']."',".$param['faultTime'].",'".$param['faultTimeDesc']."',".$param['recTime'].",";
            $sql.="'".$param['recTimeDesc']."',".$param['recStatus'].",'".$param['recStatusDesc']."','".$param['ackUserName']."',";
            $sql.="'".$param['alarmDesc']."',".$param['somState'].",'".$param['remark']."','".$param['eventName']."','".$param['reason']."',";
            $sql.=$param['defineType'].",".$param['customAlarmLevel'].",".$param['specificId'].",".$param['originalType'].")";
            $cmd = Yii::$app->db->createCommand($sql);
            $cmd->execute();
            return true;
        }
        catch(Exception $e)
        {
            var_dump($e->getMessage());
            Yii::error($e->getMessage(),'console/importDeviceAlarm');
            return false;
        }
    }

    /**
     * 获取本地所有设备IP集合
     */
    private function getLocalDeviceIps()
    {
        $query=DeviceInfo::find()->select('ip')->asArray()->all();
        return $query;
    }

}
