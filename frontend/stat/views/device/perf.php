<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */

?>
<div class="device-info-view perf_view">

    <h1><?= Html::encode( '设备性能指标') ?></h1>

    <?=GridView::widget([
        "dataProvider"=>$data,
        "columns" => [
            'taskName',
            'averageValue',
            'maximumValue',
            'minimumValue',
            'currentValue',
            //'update_time'
        ],
    ])?>
</div>
