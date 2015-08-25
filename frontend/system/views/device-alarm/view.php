<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceAlarm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Device Alarms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-alarm-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'OID',
            'originalTypeDesc',
            'deviceId',
            'deviceIp',
            'deviceName',
            'alarmLevel',
            'alarmLevelDesc',
            'alarmCategory',
            'alarmCategoryDesc',
            'faultTime:datetime',
            'faultTimeDesc',
            'recTime:datetime',
            'recTimeDesc',
            'recStatus',
            'recStatusDesc',
            'recUserName',
            'ackTime:datetime',
            'ackTimeDesc',
            'ackStatus',
            'ackStatusDesc',
            'ackUserName',
            'alarmDesc',
            'somState',
            'remark',
            'eventName',
            'reason:ntext',
            'defineType',
            'customAlarmLevel',
            'update_time',
            'specificId',
            'originalType',
        ],
    ]) ?>

</div>
