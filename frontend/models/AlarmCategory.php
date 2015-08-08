<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alarm_category".
 *
 * @property integer $id
 * @property integer $baseClass
 * @property string $baseDesc
 * @property integer $subClass
 * @property string $subDesc
 */
class AlarmCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alarm_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'baseClass', 'subClass'], 'required'],
            [['id', 'baseClass', 'subClass'], 'integer'],
            [['baseDesc', 'subDesc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'baseClass' => Yii::t('app', 'Base Class'),
            'baseDesc' => Yii::t('app', 'Base Desc'),
            'subClass' => Yii::t('app', 'Sub Class'),
            'subDesc' => Yii::t('app', 'Sub Desc'),
        ];
    }
}
