<?php

namespace frontend\models;

use frontend\models\DeviceIpfilter;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "device_alarm".
 *
 * @property integer $id
 * @property string $OID
 * @property string $originalTypeDesc
 * @property integer $deviceId
 * @property string $deviceIp
 * @property string $deviceName
 * @property integer $alarmLevel
 * @property string $alarmLevelDesc
 * @property integer $alarmCategory
 * @property string $alarmCategoryDesc
 * @property integer $faultTime
 * @property string $faultTimeDesc
 * @property integer $recTime
 * @property string $recTimeDesc
 * @property integer $recStatus
 * @property string $recStatusDesc
 * @property string $recUserName
 * @property integer $ackTime
 * @property string $ackTimeDesc
 * @property integer $ackStatus
 * @property string $ackStatusDesc
 * @property string $ackUserName
 * @property string $alarmDesc
 * @property integer $somState
 * @property string $remark
 * @property string $eventName
 * @property string $reason
 * @property integer $defineType
 * @property integer $customAlarmLevel
 * @property string $update_time
 * @property integer $specificId
 * @property integer $originalType
 */
class DeviceAlarm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_alarm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'deviceId', 'alarmLevel', 'alarmCategory', 'faultTime', 'recTime', 'recStatus', 'ackTime', 'ackStatus', 'somState', 'defineType', 'customAlarmLevel', 'specificId', 'originalType'], 'integer'],
            [['reason'], 'string'],
            [['update_time'], 'safe'],
            [['OID', 'originalTypeDesc', 'deviceName', 'alarmLevelDesc', 'alarmCategoryDesc', 'faultTimeDesc', 'recTimeDesc', 'recStatusDesc', 'recUserName', 'ackTimeDesc', 'ackStatusDesc', 'ackUserName', 'alarmDesc', 'remark', 'eventName'], 'string', 'max' => 255],
            [['deviceIp'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'OID' => Yii::t('app', '告警事件OID'),
            'originalTypeDesc' => Yii::t('app', '告警来源类型'),
            'deviceId' => Yii::t('app', '设备ID'),
            'deviceIp' => Yii::t('app', '设备IP'),
            'deviceName' => Yii::t('app', '设备名称'),
            'alarmLevel' => Yii::t('app', '告警级别'),
            'alarmLevelDesc' => Yii::t('app', '告警级别'),
            'alarmCategory' => Yii::t('app', '告警类型'),
            'alarmCategoryDesc' => Yii::t('app', '告警类型'),
            'faultTime' => Yii::t('app', 'Fault Time'),
            'faultTimeDesc' => Yii::t('app', '告警发生时间'),
            'recTime' => Yii::t('app', 'Rec Time'),
            'recTimeDesc' => Yii::t('app', '告警恢复时间'),
            'recStatus' => Yii::t('app', 'Rec Status'),
            'recStatusDesc' => Yii::t('app', '告警恢复状态'),
            'recUserName' => Yii::t('app', '告警恢复人'),
            'ackTime' => Yii::t('app', 'Ack Time'),
            'ackTimeDesc' => Yii::t('app', '告警确认时间'),
            'ackStatus' => Yii::t('app', 'Ack Status'),
            'ackStatusDesc' => Yii::t('app', '告警确认状态'),
            'ackUserName' => Yii::t('app', '告警确认人'),
            'alarmDesc' => Yii::t('app', '告警信息'),
            'somState' => Yii::t('app', '告警分发状态'),
            'remark' => Yii::t('app', '告警备注'),
            'eventName' => Yii::t('app', '告警事件名称'),
            'reason' => Yii::t('app', '告警事件原因'),
            'defineType' => Yii::t('app', '告警定义类型'),
            'customAlarmLevel' => Yii::t('app', '用户自定义级别'),
            'update_time' => Yii::t('app', 'Update Time'),
            'specificId' => Yii::t('app', 'Specific ID'),
            'originalType' => Yii::t('app', 'Original Type'),
        ];
    }
    public function getDefineTypeShow(){
        switch($this->defineType){
            case 0:
                return '系统预定义';
            case 1:
                return '用户定义';
            default:
                return '';
        }
    }
    /**
     * 告警分类统计图表
     * @return array
     */
    public static function getTypeChartData(){
        /*$ips = DeviceIpfilter::getIdsByType(DeviceIpfilter::TYPE_BUILD);
        $sql = "select a.baseDesc as category, a.id as categoryId, count(b.id) as count ,a.color as color
        from alarm_category a
        left join (select * from device_alarm where deviceIp in ('".implode("','",$ips)."')) b on a.id = b.alarmCategory
        where a.id<100
        group by a.baseClass";*/
        $sql = "select a.baseDesc as category, a.id as categoryId, count(b.id) as count ,a.color as color
        from alarm_category a
        left join device_alarm b on a.id = b.alarmCategory
        where a.id<100
        group by a.baseClass";
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
        /*
        $rows = (new Query())
            ->from("alarm_category a")
            ->leftJoin("device_alarm b","a.id = b.alarmCategory")
            ->where(["b.deviceIp"=>$ips])
            ->select(["category"=>"a.subDesc","categoryId"=>"a.id","count"=>"count(b.id)","color"=>"a.color"])
            ->groupBy("a.id")
            ->all();
        */
        $categories = [];
        $data = [];
        $colors = [];
        foreach($rows as $row){
            $categories[] = $row["category"];
            $data[] = [
                "name"=>$row["category"],
                "value"=>(int)$row["count"],
            ];
            $colors[] = $row["color"];

        }

        return [
            "categories" => $categories,
            "data" =>$data,
            "colors" => $colors
        ];
    }

    public static function getLevelChartData(){
        /*
        $ips = DeviceIpfilter::getIdsByType(DeviceIpfilter::TYPE_BUILD);
        $sql = "select a.desc as category, a.id as categoryId, count(b.id) as count ,a.color as color from alarm_level a
         left join (select * from device_alarm where deviceIp in ('".implode("','",$ips)."')) b on a.id = b.alarmLevel where a.id<10
         group by a.id";
        */
        $sql = "select a.desc as category, a.id as categoryId, count(b.id) as count ,a.color as color from alarm_level a
         left join device_alarm b on a.id = b.alarmLevel where a.id<10
         group by a.id";
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
        $data = [];
        $categories = [];
        $colors = [];
        foreach($rows as $row){
            $colors[] = $row["color"];
            $data[] = [
                "name" => $row["category"],
                "value" => (int)$row["count"],
            ];
            $categories[] = $row["category"];
        }
        return [
            "data" => $data,
            "categories" => $categories,
            "colors" => $colors
        ];
    }
}
