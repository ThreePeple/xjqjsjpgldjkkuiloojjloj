<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */
$this->title = "设备详细信息";
?>
<div class="device-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'label',
            'ip',
            'mask',
            'mac',
            [
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
