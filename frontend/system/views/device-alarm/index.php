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
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">筛选</h3>
                </div>
                <div class="panel-body">
                    <?=$this->render("_search",["model"=>$searchModel]);?>
                </div>
            </div>
        </div>
    </div>

    <?=
    GridView::widget([
        "dataProvider"=>$dataProvider,
        //"filterModel" => $searchModel,
        'pjax'=> true,
        "columns" => [
            'deviceIp',
            'deviceName',
            // 'alarmLevel',
            'alarmLevelDesc',
            // 'alarmCategory',
            //'alarmCategoryDesc',
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
            'alarmDesc',
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
                'template' => '{view}',
                'buttons' => [
                    "view" => function($url,$model,$key){
                        $url = ($model instanceof app\models\WirelessDeviceAlarm)? Url::toRoute(['view',
                            "type"=>2,"id"=>$model->id]):
                        $url;
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
                ],
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.$title.'</h3>',
            'type'=>'default',
            'before'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 刷新列表', ['/'
                .$this->context->action->getUniqueId
            ()],
                ['class' => 'btn
            btn-info']),
        ],
        "export"=>false,
    ]);
    ?>

</div>
