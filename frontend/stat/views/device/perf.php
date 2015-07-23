<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */

$this->title = '设备性能指标';
$this->params['breadcrumbs'][] = ['label' => '设备性能指标', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-repeat"></i>刷新数据', ['perf', 'id' => $model->devId], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'instId',
            'insDesc',
            'devId',
            'devDesc',
            'taskId',
            'taskDesc',
            'dataVal',
            'dataTime',
            'dataTimeStr',
            'dataType',
            'minVal',
            'maxVal',
            'sumVal',
            'sumCount',
            'update_time',
        ],
    ]) ?>

</div>
