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
       $api_path=Constants::WIRELESS_DEVICE;
        $query=[
            'resPrivilegeFilter'=>false,
            'start'=>0,
            'orderBy'=>id,
            'desc'=>false,
            'size'=>500,
            'total'=>false,
        ];
        //设备信息列表
        $url=$host.$api_path;
        $client=(new RestfulClient())->get($url,$query);
        if(!$client->hasErrors())
        {
            $data = $client->getData();
           // var_dump($data['device']);
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
     * 查询当前接入设备
     */
    public function actionIpmaclearn()
    {

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
            //对原始处理进行特殊处理
            //类型映射
            $map_id=$this->getDeviceMapCategoryID($param['ip']);
            $param['categoryId']=empty($map_id)?$param['categoryId']:$map_id;

            //echo '22'.$map_id;die;
            //处理设备系列
            $series=$this->getDeviceSeries($param['series']);
            $param['series_id']=$series['series_id'];
            $param['series_name']=$series['series_name'];
            //处理设备型号
            $models=$this->getDeviceModel($param['model']);
            $param['model_id']=$models['model_id'];
            $param['model_name']=$models['model_name'];



/*            $sql="insert into `wireless_device_info`(id,`label`,ip,mask,status,sysName,location,sysOid,runtime,lastPoll,categoryId,supportPing,";
            $sql.="webMgrPort,configPollTime,statePollTime,typeName,symbolType,symbolDesc,mac,phyName,phyCreateTime,series_id,model_id,";
            $sql.="series_name,model_name,statusDesc)";
            $sql.=" values(".$param['id'].",'".$param['label']."','".$param['ip']."','".$param['mask']."',".$param['status'].",'".$param['sysName']."',";
            $sql.="'".$param['location']."','".$param['sysOid']."','".$param['runtime']."','".$param['lastPoll']."',".$param['categoryId'].",".$param['supportPing'];
            $sql.=",".$param['webMgrPort'].",".$param['configPollTime'].",".$param['statePollTime'].",'".$param['typeName']."',".$param['symbolType'];
            $sql.=",'".$param['symbolDesc']."','".$param['mac']."','".$param['phyName']."','".$param['phyCreateTime']."',".$param['series_id'];
            $sql.=",".$param['model_id'].",'".$param['series_name']."','".$param['model_name']."') on duplicate key update ";
            $sql.="id=".$param['id'].",label='".$param['label']."',mask='".$param['mask']."',status=".$param['status'].",sysName='".$param['sysName']."',";
            $sql.="location='".$param['location']."',sysOid='".$param['sysOid']."',runtime='".$param['runtime']."',lastPoll='".$param['lastPoll']."'";
            $sql.=",categoryId=".$param['categoryId'].",supportPing=".$param['supportPing'].",webMgrPort=".$param['webMgrPort'].",configPollTime=";
            $sql.=$param['configPollTime'].",statePollTime=".$param['statePollTime'].",typeName='".$param['typeName']."',symbolType=".$param['symbolType'];
            $sql.=",'".$param['symbolDesc']."',mac='".$param['mac']."',phyName='".$param['phyName']."',phyCreateTime='".$param['phyCreateTime']."'";
            $sql.=",series_id=".$param['series_id'].",model_id=".$param['model_id'].",series_name='".$param['series_name']."',model_name='".$param['model_name']."'";
            $sql.=",statusDesc='".$param['statusDesc']."'";*/
            //echo $sql;die;


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
    private function getDevices()
    {
        $devices=DeviceInfo::find();
    }
    /**
     * 从表中获取无线设备信息
     */
    private function getWirelessDevices()
    {

    }
}
