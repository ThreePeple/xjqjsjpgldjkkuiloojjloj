<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alarm_time_range".
 *
 * @property integer $id
 * @property string $desc
 */
class AlarmTimeRange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alarm_time_range';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'desc' => Yii::t('app', 'Desc'),
        ];
    }
}
