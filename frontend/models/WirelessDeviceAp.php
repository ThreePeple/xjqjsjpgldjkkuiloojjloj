<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wireless_device_ap".
 *
 * @property integer $id
 * @property string $label
 * @property string $apAlias
 * @property integer $isFit
 * @property string $sysName
 * @property integer $status
 * @property string $ipAddress
 * @property string $type
 * @property integer $onlineStatus
 * @property string $macAddress
 * @property string $softwareVersion
 * @property string $hardwareVersion
 * @property integer $onlineClientCount
 * @property string $serialId
 * @property string $acLabel
 * @property string $acIpAddress
 * @property integer $acDevId
 * @property string $location
 * @property integer $connectType
 */
class WirelessDeviceAp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_ap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isFit', 'status', 'onlineStatus', 'onlineClientCount', 'acDevId', 'connectType'], 'integer'],
            [['label', 'apAlias', 'sysName', 'ipAddress', 'type', 'macAddress', 'softwareVersion', 'hardwareVersion', 'serialId', 'acLabel', 'acIpAddress', 'location'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'apAlias' => 'Ap Alias',
            'isFit' => 'Is Fit',
            'sysName' => 'Sys Name',
            'status' => 'Status',
            'ipAddress' => 'Ip Address',
            'type' => 'Type',
            'onlineStatus' => 'Online Status',
            'macAddress' => 'Mac Address',
            'softwareVersion' => 'Software Version',
            'hardwareVersion' => 'Hardware Version',
            'onlineClientCount' => 'Online Client Count',
            'serialId' => 'Serial ID',
            'acLabel' => 'Ac Label',
            'acIpAddress' => 'Ac Ip Address',
            'acDevId' => 'Ac Dev ID',
            'location' => 'Location',
            'connectType' => 'Connect Type',
        ];
    }
}
