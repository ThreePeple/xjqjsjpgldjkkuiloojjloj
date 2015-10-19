<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sms_template".
 *
 * @property integer $id
 * @property string $content
 * @property string $name
 */
class SmsTemplate extends \yii\db\ActiveRecord
{
    static $template_fields = [
        '__ALARM_LEVEL__' => 'alarmLevelDesc',
        '__ALARM_CATEGORY__' => 'alarmCategoryDesc',
        '__EVENT_NAME__' => 'eventName',
        '__ALARM_REASON__' => 'reason',
        '__ALARM_DESC__' => 'alarmDesc',
        '__DEVICE_NAME__' => 'deviceName',
        '__DEVICE_IP__' => 'deviceIp',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [["name","content"],'required'],
            [['content'], 'string','max'=>255],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => '内容',
            'name' => '名称',
        ];
    }

    public function attributeHints(){
        return [
            //"username" => '登录使用的用户名',
        ];
    }

    public function getMacroVariables(){
        $micros = [];
        $model = new DeviceAlarm();
        foreach(self::$template_fields as $micro=>$field){
            $micros[$micro] = $model->getAttributeLabel($field);
        }
        return $micros;
    }
}
