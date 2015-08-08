<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_series".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $preDefined
 * @property integer $vendor_id
 * @property string $update_time
 */
class DeviceSeries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_series';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'preDefined', 'vendor_id'], 'integer'],
            [['update_time'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'preDefined' => Yii::t('app', 'Pre Defined'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}
