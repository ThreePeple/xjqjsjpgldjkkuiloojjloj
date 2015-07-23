<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => 'Device Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
        ],
    ]) ?>

</div>
