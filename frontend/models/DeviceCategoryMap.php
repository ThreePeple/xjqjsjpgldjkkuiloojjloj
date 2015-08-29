<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "device_category_map".
 *
 * @property string $ip
 * @property integer $categoryId
 */
class DeviceCategoryMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_category_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'categoryId'], 'required'],
            [['categoryId'], 'integer'],
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
            'categoryId' => 'Category ID',
        ];
    }
}
