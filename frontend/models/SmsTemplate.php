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
}
