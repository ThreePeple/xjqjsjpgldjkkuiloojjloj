<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SmsTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sms Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-template-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'content:ntext',
            [
                'class' => 'yii\grid\ActionColumn'
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 消息模版列表</h3>',
            'type'=>'default',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 新建模版', ['create'], ['class' => 'btn btn-primary']),
        ],
        'export' => false
    ]); ?>

</div>
