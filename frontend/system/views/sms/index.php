<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SmsConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-config-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'告警条件',
                'value' => 'conditionShow'
            ],
            [
                'label' => "消息模版",
                "value" => 'template'
            ],
            [
                'label' => '接收用户',
                "value" => 'users'
            ],
            [
                'class' => 'yii\grid\ActionColumn',

            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 消息设置列表</h3>',
            'type'=>'default',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新建配置', ['create'], ['class' => 'btn btn-primary']),
        ],
        'export' => false
    ]); ?>

</div>
