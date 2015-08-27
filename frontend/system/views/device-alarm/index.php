<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeviceAlarmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-alarm-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?=
    GridView::widget([
        "dataProvider"=>$dataProvider,
        "filterModel" => $searchModel,
        'pjax'=> true,
        "columns" => [
            'deviceId',
            'deviceIp',
            'deviceName',
            // 'alarmLevel',
            'alarmLevelDesc',
            // 'alarmCategory',
            'alarmCategoryDesc',
            // 'faultTime:datetime',
            'faultTimeDesc',
            // 'recTime:datetime',
            'recTimeDesc',
            // 'recStatus',
            // 'recStatusDesc',
            // 'recUserName',
            // 'ackTime:datetime',
            // 'ackTimeDesc',
            // 'ackStatus',
            // 'ackStatusDesc',
            // 'ackUserName',
            // 'alarmDesc',
            // 'somState',
            // 'remark',
            // 'eventName',
            // 'reason:ntext',
            // 'defineType',
            // 'customAlarmLevel',
            // 'update_time',
            // 'specificId',
            // 'originalType',

            [
                'class' => '\kartik\grid\ActionColumn',
                'width' => '50px',
                'header' => '',
                'template' => '{delete}'
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.$title.'</h3>',
            'type'=>'default',
            'before'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 刷新列表', ['index'], ['class' => 'btn btn-info']),
        ],
        "export"=>false,
    ]);
    ?>

</div>
