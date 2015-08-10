<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WirelessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wireless Device Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wireless-device-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wireless Device Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'label',
            'ip',
            'mask',
            'status',
            // 'sysName',
            // 'location',
            // 'sysOid',
            // 'runtime',
            // 'lastPoll',
            // 'categoryId',
            // 'supportPing',
            // 'webMgrPort',
            // 'configPollTime:datetime',
            // 'statePollTime:datetime',
            // 'typeName',
            // 'positionX',
            // 'positionY',
            // 'symbolType',
            // 'symbolDesc:ntext',
            // 'mac',
            // 'phyName',
            // 'phyCreateTime',
            // 'series_id',
            // 'model_id',
            // 'interfaces:ntext',
            // 'category',
            // 'update_time',
            // 'series_name',
            // 'model_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
