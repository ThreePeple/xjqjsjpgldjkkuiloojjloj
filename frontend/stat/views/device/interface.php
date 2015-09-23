<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */

?>
<div class="device-info-view perf_view">

    <h1><?= Html::encode( '端口性能信息') ?></h1>

    <?=GridView::widget([
        "dataProvider"=>$data,
        "columns" => [
            'taskName',
            'objIndexDesc',
            'averageValue',
            'maximumValue',
            'minimumValue',
            'currentValue',
            'update_time'
        ],
    ])?>
</div>
