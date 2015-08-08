<?php

namespace app\models;

use Yii;

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
            'OID' => Yii::t('app', 'Oid'),
            'originalTypeDesc' => Yii::t('app', 'Original Type Desc'),
            'deviceId' => Yii::t('app', 'Device ID'),
            'deviceIp' => Yii::t('app', 'Device Ip'),
            'deviceName' => Yii::t('app', 'Device Name'),
            'alarmLevel' => Yii::t('app', 'Alarm Level'),
            'alarmLevelDesc' => Yii::t('app', '告警级别'),
            'alarmCategory' => Yii::t('app', 'Alarm Category'),
            'alarmCategoryDesc' => Yii::t('app', '告警类型'),
            'faultTime' => Yii::t('app', 'Fault Time'),
            'faultTimeDesc' => Yii::t('app', '发生时间'),
            'recTime' => Yii::t('app', 'Rec Time'),
            'recTimeDesc' => Yii::t('app', '响应时间'),
            'recStatus' => Yii::t('app', 'Rec Status'),
            'recStatusDesc' => Yii::t('app', 'Rec Status Desc'),
            'recUserName' => Yii::t('app', 'Rec User Name'),
            'ackTime' => Yii::t('app', 'Ack Time'),
            'ackTimeDesc' => Yii::t('app', 'Ack Time Desc'),
            'ackStatus' => Yii::t('app', 'Ack Status'),
            'ackStatusDesc' => Yii::t('app', 'Ack Status Desc'),
            'ackUserName' => Yii::t('app', 'Ack User Name'),
            'alarmDesc' => Yii::t('app', 'Alarm Desc'),
            'somState' => Yii::t('app', 'Som State'),
            'remark' => Yii::t('app', 'Remark'),
            'eventName' => Yii::t('app', 'Event Name'),
            'reason' => Yii::t('app', 'Reason'),
            'defineType' => Yii::t('app', 'Define Type'),
            'customAlarmLevel' => Yii::t('app', 'Custom Alarm Level'),
            'update_time' => Yii::t('app', 'Update Time'),
            'specificId' => Yii::t('app', 'Specific ID'),
            'originalType' => Yii::t('app', 'Original Type'),
        ];
    }
}
