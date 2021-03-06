<?php

namespace app\models;

use frontend\models\DeviceIpfilter;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "device_task".
 *
 * @property integer $instId
 * @property string $insDesc
 * @property integer $devId
 * @property string $devDesc
 * @property integer $taskId
 * @property string $taskDesc
 * @property double $dataVal
 * @property string $dataTime
 * @property string $dataTimeStr
 * @property integer $dataType
 * @property double $minVal
 * @property double $maxVal
 * @property double $sumVal
 * @property integer $sumCount
 * @property string $update_time
 */
class DeviceTask extends \yii\db\ActiveRecord
{
    const TASKID_CPU = 2;       //CPU
    const TASKID_MEMORY = 4;    //内存
    const TASKID_RES_TIME = 6;  //响应时间

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instId', 'devId', 'taskId'], 'required'],
            [['instId', 'devId', 'taskId', 'dataType', 'sumCount'], 'integer'],
            [['dataVal', 'minVal', 'maxVal', 'sumVal'], 'number'],
            [['dataTime', 'dataTimeStr', 'update_time'], 'safe'],
            [['insDesc', 'devDesc', 'taskDesc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'instId' => Yii::t('app', 'Inst ID'),
            'insDesc' => Yii::t('app', 'Ins Desc'),
            'devId' => Yii::t('app', 'Dev ID'),
            'devDesc' => Yii::t('app', 'Dev Desc'),
            'taskId' => Yii::t('app', 'Task ID'),
            'taskDesc' => Yii::t('app', 'Task Desc'),
            'dataVal' => Yii::t('app', 'Data Val'),
            'dataTime' => Yii::t('app', 'Data Time'),
            'dataTimeStr' => Yii::t('app', 'Data Time Str'),
            'dataType' => Yii::t('app', 'Data Type'),
            'minVal' => Yii::t('app', 'Min Val'),
            'maxVal' => Yii::t('app', 'Max Val'),
            'sumVal' => Yii::t('app', 'Sum Val'),
            'sumCount' => Yii::t('app', 'Sum Count'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public static function getPrefList($deviceId){
        $rows = self::find()->where(["devId"=>$deviceId])
            ->select(["taskDesc","dataVal"])
            ->orderBy("update_time desc")
            ->groupBy("taskId")
            ->asArray()
            ->all();
        return ArrayHelper::map($rows,"taskDesc","dataVal");
    }

    /**
     * 大屏滚动性能指标信息
     * @return string
     */
    public static function getLastPreDatas(){
        $ips = DeviceIpfilter::getIdsByType(ViewTemplate::TYPE_BUILD);

        $rows =(new Query())
            ->from("device_task a")
            ->innerJoin("device_info b","a.devId = b.id")
            ->where(["b.ip"=>$ips])
            ->select(["id"=>"a.devId","label"=>"b.label","ip"=>"b.ip","key"=>"a.taskDesc","value"=>"a.dataVal"])
            ->groupBy("a.devId,a.taskId")
            ->orderBy("a.devId asc,a.dataTime desc")
            ->all();

        $data = [];
        foreach($rows as $row){
            $deviceId = $row["id"];
            if(!isset($data[$deviceId])){
                $data[$deviceId]=[];
                $data[$deviceId][] = $row["label"].'('.$row["ip"].')';
            }
            $data[$deviceId][] = [$row["key"],$row["value"]];
        }

        $html =[];
        foreach($data as $id=>$item){
            $table = [];
            $table[] = '<table>';
            $table[] = '<tr><th colspan="2">'.$item[0].'</th></tr>';
            foreach($item as $i=>$d){
                if($i==0) continue;
                $table[]= '<tr><th>'.$d[0].'</th><td>'.$d[1].'</td></tr>';
            }
            $table[] = '</table>';
            $html[] = implode("\n",$table);
        }
        //return implode('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$html);
        return '<li>'.implode('</li><li>',$html).'</li>';
    }

}
