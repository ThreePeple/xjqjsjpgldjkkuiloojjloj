<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AccessDeviceInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Access Device Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-device-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Access Device Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'deviceId',
            'deviceIp',
            'ifIndex',
            'ifDesc',
            // 'vlanId',
            // 'learnIp',
            // 'learnMac',
            // 'status',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
