<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */

?>
<div class="device-info-view perf_view">

    <h1><?= Html::encode( '设备性能指标') ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-repeat"></i>刷新数据', "javascript:void(0)", ['class' => 'btn btn-primary',"id"=>"refresh_perf"]) ?>
    </p>
    <table class="table table-striped table-bordered detail-view">
        <tbody>
        <?php
        foreach($data as $key=>$val){
            echo '<tr><th>'.$key.'</th><td>'.$val.'</td></tr>';
        }
        ?>
        </tbody></table>

</div>
