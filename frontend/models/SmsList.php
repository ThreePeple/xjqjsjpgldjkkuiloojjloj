<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "sms_list".
 *
 * @property integer $id
 * @property string $receivers
 * @property string $content
 * @property integer $status
 * @property integer $send_times
 * @property string $create_time
 * @property string $update_time
 */
class SmsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
                'value' => function($event){
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receivers'], 'string'],
            [['status', 'send_times'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'receivers' => 'Receivers',
            'content' => 'Content',
            'status' => 'Status',
            'send_times' => 'Send Times',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
