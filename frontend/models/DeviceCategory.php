<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $preDefined
 * @property string $update_time
 */
class DeviceCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'preDefined'], 'integer'],
            [['update_time','name'], 'safe'],
            [['name'], 'string', 'max' => 255]
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
            'preDefined' => Yii::t('app', 'Pre Defined'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }
}
