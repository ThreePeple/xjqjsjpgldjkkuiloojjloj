<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "wireless_device_task_summary".
 *
 * @property integer $id
 * @property integer $taskId
 * @property string $taskName
 * @property integer $devId
 * @property integer $instId
 * @property string $objIndex
 * @property string $objIndexDesc
 * @property string $averageValue
 * @property string $maximumValue
 * @property string $minimumValue
 * @property string $currentValue
 * @property string $summaryValue
 */
class WirelessDeviceTaskSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_task_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taskId', 'devId'], 'required'],
            [['taskId', 'devId', 'instId'], 'integer'],
            [['taskName', 'objIndex', 'objIndexDesc', 'averageValue', 'maximumValue', 'minimumValue', 'currentValue', 'summaryValue'], 'string', 'max' => 128],
            [['taskId', 'devId'], 'unique', 'targetAttribute' => ['taskId', 'devId'], 'message' => 'The combination of Task ID and Dev ID has already been taken.']
        ];
    }

    public function attributeLabels()
    {

        return [
            'id' => 'ID',
            'taskId' => '指标ID',
            'taskName' => '指标名称',
            'devId' => '设备ID',
            'instId' => '实例ID',
            'objIndex' => '对象索引',
            'objIndexDesc' => '对象描述',
            'averageValue' => '平均值',
            'maximumValue' => '最大值',
            'minimumValue' => '最小值',
            'currentValue' => '当前值',
            'summaryValue' => '总计',
        ];
    }
}
