<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_model".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $sysOid
 * @property integer $vendor_id
 * @property integer $series_id
 * @property integer $category_id
 * @property string $update_time
 */
class DeviceModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'vendor_id', 'series_id', 'category_id'], 'integer'],
            [['update_time'], 'safe'],
            [['name', 'description', 'sysOid'], 'string', 'max' => 255]
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
            'sysOid' => Yii::t('app', 'Sys Oid'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'series_id' => Yii::t('app', 'Series ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public function getVendor(){
        return $this->hasOne(DeviceVendor::className(),["id"=>"vendor_id"]);
    }
}
