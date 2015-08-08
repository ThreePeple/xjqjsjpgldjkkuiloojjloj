<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_interface_task".
 *
 * @property integer $id
 * @property integer $instanceId
 * @property string $instanceName
 * @property integer $devId
 * @property string $devName
 * @property string $devDisplayName
 * @property string $devIP
 * @property integer $taskId
 * @property string $taskName
 * @property string $taskNameWithUnit
 * @property integer $objIndex
 * @property string $objIndexDesc
 * @property double $averageValue
 * @property double $maximumValue
 * @property double $currentValue
 * @property double $summaryValue
 * @property string $dateTime
 * @property integer $dataGranularity
 */
class DeviceInterfaceTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_interface_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instanceId', 'devId', 'taskId', 'objIndex', 'dataGranularity'], 'integer'],
            [['devId', 'taskId'], 'required'],
            [['averageValue', 'maximumValue', 'currentValue', 'summaryValue'], 'number'],
            [['dateTime'], 'safe'],
            [['instanceName', 'devName', 'devDisplayName', 'taskName', 'taskNameWithUnit', 'objIndexDesc'], 'string', 'max' => 255],
            [['devIP'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'instanceId' => Yii::t('app', 'Instance ID'),
            'instanceName' => Yii::t('app', 'Instance Name'),
            'devId' => Yii::t('app', 'Dev ID'),
            'devName' => Yii::t('app', 'Dev Name'),
            'devDisplayName' => Yii::t('app', 'Dev Display Name'),
            'devIP' => Yii::t('app', 'Dev Ip'),
            'taskId' => Yii::t('app', 'Task ID'),
            'taskName' => Yii::t('app', 'Task Name'),
            'taskNameWithUnit' => Yii::t('app', 'Task Name With Unit'),
            'objIndex' => Yii::t('app', 'Obj Index'),
            'objIndexDesc' => Yii::t('app', 'Obj Index Desc'),
            'averageValue' => Yii::t('app', 'Average Value'),
            'maximumValue' => Yii::t('app', 'Maximum Value'),
            'currentValue' => Yii::t('app', 'Current Value'),
            'summaryValue' => Yii::t('app', 'Summary Value'),
            'dateTime' => Yii::t('app', 'Date Time'),
            'dataGranularity' => Yii::t('app', 'Data Granularity'),
        ];
    }
}
