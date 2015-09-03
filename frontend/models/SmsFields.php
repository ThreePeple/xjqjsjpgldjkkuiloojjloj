<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sms_fields".
 *
 * @property integer $id
 * @property string $label
 * @property string $field
 * @property string $macro-variable
 */
class SmsFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label'], 'string', 'max' => 128],
            [['field', 'macro-variable'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'field' => 'Field',
            'macro-variable' => 'Macro Variable',
        ];
    }
}
