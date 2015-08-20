<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wireless_device_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $preDefined
 * @property string $update_time
 * @property string $node_group
 */
class WirelessDeviceCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_category';
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
            [['name'], 'string', 'max' => 255],
            [['node_group'], 'string', 'max' => 50]
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
            'node_group' => Yii::t('app', 'Node Group'),
        ];
    }
}
