<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WirelessDeviceInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wireless Device Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wireless-device-info-view">

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
            'label',
            'ip',
            'mask',
            'status',
            'sysName',
            'location',
            'sysOid',
            'runtime',
            'lastPoll',
            'categoryId',
            'supportPing',
            'webMgrPort',
            'configPollTime:datetime',
            'statePollTime:datetime',
            'typeName',
            'positionX',
            'positionY',
            'symbolType',
            'symbolDesc:ntext',
            'mac',
            'phyName',
            'phyCreateTime',
            'series_id',
            'model_id',
            'interfaces:ntext',
            'category',
            'update_time',
            'series_name',
            'model_name',
        ],
    ]) ?>

</div>
