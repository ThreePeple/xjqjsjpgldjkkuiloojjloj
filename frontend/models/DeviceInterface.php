<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_interface".
 *
 * @property integer $id
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
class DeviceInterface extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_interface';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ifIndex', 'ifType'], 'required'],
            [['ifIndex', 'ifType', 'adminStatus', 'operationStatus', 'showStatus', 'ifspeed', 'appointedSpeed', 'mtu'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'ifIndex' => Yii::t('app', 'If Index'),
            'ifType' => Yii::t('app', 'If Type'),
            'ifTypeDesc' => Yii::t('app', 'If Type Desc'),
            'ifDescription' => Yii::t('app', 'If Description'),
            'adminStatus' => Yii::t('app', 'Admin Status'),
            'adminStatusDesc' => Yii::t('app', 'Admin Status Desc'),
            'operationStatus' => Yii::t('app', 'Operation Status'),
            'operationStatusDesc' => Yii::t('app', 'Operation Status Desc'),
            'showStatus' => Yii::t('app', 'Show Status'),
            'statusDesc' => Yii::t('app', 'Status Desc'),
            'ifspeed' => Yii::t('app', 'Ifspeed'),
            'appointedSpeed' => Yii::t('app', 'Appointed Speed'),
            'ifAlias' => Yii::t('app', 'If Alias'),
            'phyAddress' => Yii::t('app', 'Phy Address'),
            'mtu' => Yii::t('app', 'Mtu'),
            'lastChange' => Yii::t('app', 'Last Change'),
            'ip' => Yii::t('app', 'Ip'),
            'mask' => Yii::t('app', 'Mask'),
            'lastChangeTime' => Yii::t('app', 'Last Change Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}
