<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "alarm_level_blacklist".
 *
 * @property integer $id
 * @property integer $level
 * @property string $level_name
 */
class AlarmLevelBlacklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alarm_level_blacklist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level'], 'integer'],
            [['level_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'level_name' => '告警级别',
        ];
    }
}
