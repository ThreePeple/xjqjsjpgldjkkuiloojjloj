<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */
?>
<style>
    .box10 {
        background: transparent;
        font-family: PingHei, STHeitiSC-Light, 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }
    .box10 ul span.img{
        margin-top: 180px !important;
        margin-bottom: -5px !important;
        -webkit-transform:scale(0.7);
    }
    .box10 ul li:hover{
        color: #efefef;
    }
    .box10 ul span.txt{
        line-height: 27px !important;
    }
    .device-info-view  h1{
        font-size: 16px;
        margin: 8px 0  20px;
    }
    .device-info-view.view th{
        width: 120px;
    } 
    .device-info-view.view td{
        color: #efefef;
    }
    .device-info-view.view tr:hover > *{
        background-color: #8Fe75B;
    }
    table.kv-grid-table thead th{
        text-align: center;
        font-weight: normal;
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
