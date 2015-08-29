<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceAlarm */

$this->title = '设备告警信息';
$this->params['breadcrumbs'][] = ['label' => 'Device Alarms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-alarm-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'originalTypeDesc',
            'deviceIp',
            'deviceName',
            'alarmLevelDesc',
            'alarmCategoryDesc',
            'faultTimeDesc',
            'recTimeDesc',
            'recStatusDesc',
            'recUserName',
            'ackTimeDesc',
            'ackStatusDesc',
            'ackUserName',
            'alarmDesc',
            'somState',
            'remark',
            'eventName',
            'reason:ntext',
            'defineType',
            'customAlarmLevel',
            'specificId',
            [
                'attribute' => 'defineType',
                'value' => 'defineTypeShow'

            ]
        ],
    ]) ?>

</div>
