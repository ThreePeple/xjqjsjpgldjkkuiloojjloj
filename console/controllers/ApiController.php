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
                   if($this->importWirelessDevice($_data))
                        echo $_data['ip']." import ok\n";
                    else
                    {
                        echo $_data['ip']." import fail\n";
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/actionWirelessDeviceSourceTask');
        }
    }
    /**
     * 有线设备相关资源任务
     */
    public function actionDeviceSourceTask()
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
                    if($this->importDevice($_data,"device_info"))
                        echo $_data['ip']." import ok\n";
                    else
                    {
                        echo $_data['ip']." import fail\n";
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/actionWirelessDeviceSourceTask');
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
                 var_dump($data);
                if(isset($data['ipMacLearnResult']))
                {
                    foreach($data['ipMacLearnResult'] as $_data)
                    {
                        if($this->importIpMacLearn($_data))
                            echo $_data['learnIp']." import ok\n";
                        else
                        {
                            echo $_data['learnIp']." import fail\n";
                            break;
                        }
                    }
                }
            }
            else
            {
                var_dump($client->getError());
                Yii::error($client->getError(),'console/actionIpmaclearn');
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
                        echo $_data['id']." import ok\n";
                    else
                    {
                        echo $_data['id']." import fail\n";
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/actionWirelessDeviceLink');
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
                        echo $_data['id']." import ok\n";
                    else
                    {
                        echo $_data['id']." import fail\n";
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/actionDeviceLink');
        }
    }

    /**
     * 性能指标基础信息
     */
    public function actionTask()
    {
        $host=Yii::$app->params['wireless_api_host'];
        //无线设备数据
        $api_path=Constants::TASK;
       /* $query=[
            'orderBy'=>'taskId',
            'desc'=>false,
        ];*/
        //设备链路信息列表
        $url=$host.$api_path;
        echo $url."\n";
        $client=(new RestfulClient("http_basic"))->get($url);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
            echo count($data);
            if(isset($data['task']))
            {
                foreach($data['task'] as $_data)
                {
                    if($this->importTask($_data))
                        echo $_data['taskId']." import ok\n";
                    else
                    {
                        echo $_data['taskId']." import fail\n";
                        break;
                    }
                }
            }
        }
        else
        {
            var_dump($client->getError());
            Yii::error($client->getError(),'console/actionTask');
        }
    }
    ///////////////////私有函数////////////////////////
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

            $sql="insert into `device_info`(id,`label`,ip,mask,status,sysName,location,sysOid,categoryId";
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
}
