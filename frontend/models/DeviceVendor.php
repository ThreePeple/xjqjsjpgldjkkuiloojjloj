<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_vendor".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $phone
 * @property string $contact
 * @property integer $preDefined
 * @property string $update_time
 */
class DeviceVendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'preDefined'], 'integer'],
            [['update_time'], 'safe'],
            [['name', 'description', 'contact'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 64]
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
            'phone' => Yii::t('app', 'Phone'),
            'contact' => Yii::t('app', 'Contact'),
            'preDefined' => Yii::t('app', 'Pre Defined'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}
