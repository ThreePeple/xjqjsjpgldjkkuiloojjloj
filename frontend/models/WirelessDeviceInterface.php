<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wireless_device_interface".
 *
 * @property integer $id
 * @property integer $device_id
 * @property integer $ifIndex
 * @property integer $ifType
 * @property string $ifTypeDesc
 * @property string $ifDescription
 * @property integer $adminStatus
 * @property string $adminStatusDesc
 * @property integer $operationStatus
 * @property string $operationStatusDesc
 * @property integer $showStatus
 * @property string $statusDesc
 * @property integer $ifspeed
 * @property integer $appointedSpeed
 * @property string $ifAlias
 * @property string $phyAddress
 * @property integer $mtu
 * @property string $lastChange
 * @property string $ip
 * @property string $mask
 * @property string $lastChangeTime
 * @property string $update_time
 */
class WirelessDeviceInterface extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_interface';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'ifIndex', 'ifType', 'adminStatus', 'operationStatus', 'showStatus', 'ifspeed', 'appointedSpeed', 'mtu'], 'integer'],
            [['ifIndex', 'ifType'], 'required'],
            [['update_time'], 'safe'],
            [['ifTypeDesc', 'ifDescription', 'adminStatusDesc', 'operationStatusDesc', 'statusDesc', 'ifAlias', 'phyAddress', 'lastChange', 'lastChangeTime'], 'string', 'max' => 255],
            [['ip', 'mask'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_id' => 'Device ID',
            'ifIndex' => 'If Index',
            'ifType' => 'If Type',
            'ifTypeDesc' => 'If Type Desc',
            'ifDescription' => 'If Description',
            'adminStatus' => 'Admin Status',
            'adminStatusDesc' => 'Admin Status Desc',
            'operationStatus' => 'Operation Status',
            'operationStatusDesc' => 'Operation Status Desc',
            'showStatus' => 'Show Status',
            'statusDesc' => 'Status Desc',
            'ifspeed' => 'Ifspeed',
            'appointedSpeed' => 'Appointed Speed',
            'ifAlias' => 'If Alias',
            'phyAddress' => 'Phy Address',
            'mtu' => 'Mtu',
            'lastChange' => 'Last Change',
            'ip' => 'Ip',
            'mask' => 'Mask',
            'lastChangeTime' => 'Last Change Time',
            'update_time' => 'Update Time',
        ];
    }
}
