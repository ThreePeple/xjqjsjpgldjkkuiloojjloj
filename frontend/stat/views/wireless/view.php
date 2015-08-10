<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */
?>
<style>
    .device-info-view  h1{
        font-size: 18px;
        margin: 8px 0;
    }
    .device-info-view.view th{
        width: 100px;
    }
    .device-info-view.view tr:hover > *{
        background-color: #8Fe75B;
    }
</style>
<div class="device-info-view view">

    <h1><?= Html::encode("设备详细信息") ?></h1>
<?php 
/*
    <!--<p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>-->
*/
?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'label',
            'ip',
            'mask',
            'mac',
            [
                'label' => "设备状态",
                'attribute'=>'statusShow',
                'format' => "raw"
            ],
            'sysName',
            'location',
            'typeName',
            'series_name',
            'model_name',
        ],
    ]) ?>

</div>
