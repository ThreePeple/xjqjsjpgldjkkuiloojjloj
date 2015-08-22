<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wireless_device_interface_task".
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
class WirelessDeviceInterfaceTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_interface_task';
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
            'id' => 'ID',
            'instanceId' => 'Instance ID',
            'instanceName' => 'Instance Name',
            'devId' => 'Dev ID',
            'devName' => 'Dev Name',
            'devDisplayName' => 'Dev Display Name',
            'devIP' => 'Dev Ip',
            'taskId' => 'Task ID',
            'taskName' => 'Task Name',
            'taskNameWithUnit' => 'Task Name With Unit',
            'objIndex' => 'Obj Index',
            'objIndexDesc' => 'Obj Index Desc',
            'averageValue' => 'Average Value',
            'maximumValue' => 'Maximum Value',
            'currentValue' => 'Current Value',
            'summaryValue' => 'Summary Value',
            'dateTime' => 'Date Time',
            'dataGranularity' => 'Data Granularity',
        ];
    }
}
