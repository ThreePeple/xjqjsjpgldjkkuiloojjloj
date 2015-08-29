<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sms_config".
 *
 * @property integer $id
 * @property string $alarmSet
 * @property string $alarmCondition
 * @property integer $smsTemplate_id
 * @property string $receivers
 * @property string $create_time
 * @property string $update_time
 */
class SmsConfig extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alarmSet', 'alarmCondition'], 'string'],
            [['smsTemplate_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['receivers'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alarmSet' => 'Alarm Set',
            'alarmCondition' => 'Alarm Condition',
            'smsTemplate_id' => 'Sms Template ID',
            'receivers' => 'Receivers',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
