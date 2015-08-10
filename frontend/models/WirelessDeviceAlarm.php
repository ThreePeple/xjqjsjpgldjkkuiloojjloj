<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wireless_device_alarm".
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
class WirelessDeviceAlarm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_alarm';
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
            'id' => 'ID',
            'OID' => 'Oid',
            'originalTypeDesc' => 'Original Type Desc',
            'deviceId' => 'Device ID',
            'deviceIp' => 'Device Ip',
            'deviceName' => 'Device Name',
            'alarmLevel' => 'Alarm Level',
            'alarmLevelDesc' => 'Alarm Level Desc',
            'alarmCategory' => 'Alarm Category',
            'alarmCategoryDesc' => 'Alarm Category Desc',
            'faultTime' => 'Fault Time',
            'faultTimeDesc' => 'Fault Time Desc',
            'recTime' => 'Rec Time',
            'recTimeDesc' => 'Rec Time Desc',
            'recStatus' => 'Rec Status',
            'recStatusDesc' => 'Rec Status Desc',
            'recUserName' => 'Rec User Name',
            'ackTime' => 'Ack Time',
            'ackTimeDesc' => 'Ack Time Desc',
            'ackStatus' => 'Ack Status',
            'ackStatusDesc' => 'Ack Status Desc',
            'ackUserName' => 'Ack User Name',
            'alarmDesc' => 'Alarm Desc',
            'somState' => 'Som State',
            'remark' => 'Remark',
            'eventName' => 'Event Name',
            'reason' => 'Reason',
            'defineType' => 'Define Type',
            'customAlarmLevel' => 'Custom Alarm Level',
            'update_time' => 'Update Time',
            'specificId' => 'Specific ID',
            'originalType' => 'Original Type',
        ];
    }
}
