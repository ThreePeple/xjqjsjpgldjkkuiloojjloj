<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "access_device_info".
 *
 * @property integer $id
 * @property integer $deviceId
 * @property string $deviceIp
 * @property integer $ifIndex
 * @property string $ifDesc
 * @property integer $vlanId
 * @property string $learnIp
 * @property string $learnMac
 * @property integer $status
 * @property string $update_time
 */
class AccessDeviceInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_device_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deviceId', 'ifIndex', 'vlanId', 'status'], 'integer'],
            [['update_time'], 'safe'],
            [['deviceIp', 'ifDesc', 'learnIp', 'learnMac'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deviceId' => 'Device ID',
            'deviceIp' => 'Device Ip',
            'ifIndex' => 'If Index',
            'ifDesc' => 'If Desc',
            'vlanId' => 'Vlan ID',
            'learnIp' => 'Learn Ip',
            'learnMac' => 'Learn Mac',
            'status' => 'Status',
            'update_time' => 'Update Time',
        ];
    }

    public function getStatusShow(){
        switch($this->status){
            case  1:
                return '已绑定';
            default:
                return '未绑定';
        }
    }
}
