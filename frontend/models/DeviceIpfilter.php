<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_ipfilter".
 *
 * @property string $ip
 * @property integer $type_id
 */
class DeviceIpfilter extends \yii\db\ActiveRecord
{
    const TYPE_BUILD = 1;
    const TYPE_WLAN = 2;
    const TYPE_WIRELESS = 3;
    const TYPE_POLYMER = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_ipfilter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['type_id'], 'integer'],
            [['ip'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip' => 'Ip',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * 根据展示图ID 获取可用ID列表
     * @param $type_id
     * @return  array ids
     */
    public static function getIdsByType($type_id){
        return self::find()->where(["type_id"=>$type_id])->select("ip")->asArray()->column();
    }

}
