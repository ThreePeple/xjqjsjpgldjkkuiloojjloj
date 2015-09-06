<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AccessDeviceInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '接入设备列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-device-info-index">

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => [
            'deviceId',
            'deviceIp',
            'ifIndex',
            'ifDesc',
             'vlanId',
             'learnIp',
             'learnMac',
            // 'status',
            // 'update_time',

            //['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.$this->title.'</h3>',
            'type'=>'default',
        ],
        'export' => false,
    ]); ?>

</div>
