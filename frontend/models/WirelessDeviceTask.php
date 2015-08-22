<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "wireless_device_task".
 *
 * @property integer $instId
 * @property string $insDesc
 * @property integer $devId
 * @property string $devDesc
 * @property integer $taskId
 * @property string $taskDesc
 * @property double $dataVal
 * @property string $dataTime
 * @property string $dataTimeStr
 * @property integer $dataType
 * @property double $minVal
 * @property double $maxVal
 * @property double $sumVal
 * @property integer $sumCount
 * @property string $update_time
 */
class WirelessDeviceTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wireless_device_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['devId', 'taskId', 'dataType', 'sumCount'], 'integer'],
            [['dataVal', 'minVal', 'maxVal', 'sumVal'], 'number'],
            [['dataTime', 'dataTimeStr', 'update_time'], 'safe'],
            [['insDesc', 'devDesc', 'taskDesc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'instId' => 'Inst ID',
            'insDesc' => 'Ins Desc',
            'devId' => 'Dev ID',
            'devDesc' => 'Dev Desc',
            'taskId' => 'Task ID',
            'taskDesc' => 'Task Desc',
            'dataVal' => 'Data Val',
            'dataTime' => 'Data Time',
            'dataTimeStr' => 'Data Time Str',
            'dataType' => 'Data Type',
            'minVal' => 'Min Val',
            'maxVal' => 'Max Val',
            'sumVal' => 'Sum Val',
            'sumCount' => 'Sum Count',
            'update_time' => 'Update Time',
        ];
    }

    public static function getPrefList($deviceId){
        $rows = self::find()->where(["devId"=>$deviceId])
            ->select(["taskDesc","dataVal"])
            ->orderBy("update_time desc")
            ->groupBy("taskId")
            ->asArray()
            ->all();
        return ArrayHelper::map($rows,"taskDesc","dataVal");
    }
}
