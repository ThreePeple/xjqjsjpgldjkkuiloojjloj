<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "info_config".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property integer $type_id
 * @property integer $is_show
 */
class InfoConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'is_show'], 'integer'],
            [['key', 'value'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'type_id' => Yii::t('app', 'Type ID'),
            'is_show' => Yii::t('app', 'Is Show'),
        ];
    }

    public static function getTipConfig($type){
        return self::find()->where(["type_id"=>$type,"is_show"=>1])->select(["key","value","type_id"])->asArray()->all();
    }
}
