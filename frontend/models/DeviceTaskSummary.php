<?php

namespace frontend\models;

use app\models\ViewTemplate;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "device_task_summary".
 *
 * @property integer $id
 * @property integer $taskId
 * @property string $taskName
 * @property integer $devId
 * @property integer $instId
 * @property string $objIndex
 * @property string $objIndexDesc
 * @property string $averageValue
 * @property string $maximumValue
 * @property string $minimumValue
 * @property string $currentValue
 * @property string $summaryValue
 */
class DeviceTaskSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_task_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taskId', 'devId'], 'required'],
            [['taskId', 'devId', 'instId'], 'integer'],
            [['taskName', 'objIndex', 'objIndexDesc', 'averageValue', 'maximumValue', 'minimumValue', 'currentValue', 'summaryValue'], 'string', 'max' => 128],
            [['taskId', 'devId'], 'unique', 'targetAttribute' => ['taskId', 'devId'], 'message' => 'The combination of Task ID and Dev ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     * id 自增
    taskId 指标ID
    taskName 指标名称
    devId 设备ID
    instId 实例ID（应该是接口的自增主键）
    objIndex 对象索引
    objIndexDesc 对象描述
    averageValue 平均值
    maximumValue 最大值
    minimumValue 最小值
    currentValue 当前值
    summaryValue 总计
     */
    public function attributeLabels()
    {

        return [
            'id' => 'ID',
            'taskId' => '指标ID',
            'taskName' => '指标名称',
            'devId' => '设备ID',
            'instId' => '实例ID',
            'objIndex' => '对象索引',
            'objIndexDesc' => '对象描述',
            'averageValue' => '平均值',
            'maximumValue' => '最大值',
            'minimumValue' => '最小值',
            'currentValue' => '当前值',
            'summaryValue' => '总计',
        ];
    }
    public static function getPrefList($deviceId){

        $rows = self::find()->where(["devId"=>$deviceId])
            ->select(["taskName","dataVal"])
            ->orderBy("update_time desc")
            ->groupBy("taskId")
            ->asArray()
            ->all();
        return ArrayHelper::map($rows,"taskName","dataVal");
    }

    /**
     * 大屏滚动性能指标信息
     * @return string
     */
    public static function getLastPreDatas(){
        $ips = DeviceIpfilter::getIdsByType(ViewTemplate::TYPE_BUILD);

        $rows =(new Query())
            ->from("device_task_summary a")
            ->innerJoin("device_info b","a.devId = b.id")
            ->where(["b.ip"=>$ips])
            ->select(["id"=>"a.devId","label"=>"b.label","ip"=>"b.ip","key"=>"a.taskName","value"=>"a.currentValue"])
            ->groupBy("a.devId,a.taskId")
            ->orderBy("a.devId asc,a.instId desc")
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
