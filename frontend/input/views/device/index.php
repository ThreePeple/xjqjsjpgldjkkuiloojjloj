<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\DeviceInfo;
?>
<div class="row" >
    <div class="col-md-12">
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
            "filterModel" => $searchModel,
            'pjax'=> true,
            "columns" => [
                [
                    "attribute"=>"id",
                    "width" =>"40px"
                ],
                [
                    "attribute" => "label",
                    "value" => function($model){
                            return Html::a($model->label,Url::toRoute(['/input/device/view',"id"=>$model->id]));
                        },
                    "format" => 'raw',
                    "width" => "10%"
                ],
                [
                    "attribute" => "typeName",
                    "width" => "10%"
                ],
                [
                    "label" => '<a href="javascript:void(0)">设备系列</a>',
                    'encodeLabel'=> false,
                    "attribute" => 'series',
                    "value" => "series.name",
                    "width" => "10%"
                ],
                [
                    "label" => '<a href="javascript:void(0)">设备型号</a>',
                    'encodeLabel'=> false,
                    "attribute" => 'model',
                    "value" => 'model.name',
                    "width" => "10%"
                ],
                [
                    "attribute" => "ip",
                    "width" =>"75px"
                ],
                [
                    "attribute" => "mask",
                    "width" =>"75px"
                ],
                [
                    "attribute" => "mac",
                    "width" =>"100px"
                ],
                //"phyCreateTime",
                [
                    'attribute'=>'status',
                    'vAlign'=>'middle',
                    'width'=>'90px',
                    'value'=>function ($model, $key, $index, $widget) {
                            return isset(DeviceInfo::$status_titles[$model->status])? DeviceInfo::$status_titles[$model->status] : DeviceInfo::$status_titles[0];
                        },
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>DeviceInfo::$status_titles,
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'选择状态','encode'=>false,'encodeSpaces'=>false],
                    'format'=>'raw',
                ],
                /*
                [
                    'label' => '',
                    "value" => function($model){
                            return Html::a('查看端口',Url::toRoute(['/stat/device/interface',"id"=>$model->id]),['class'=>'btn btn-link'])
                                .Html::a('性能指标',Url::toRoute(['/stat/device/perf',"id"=>$model->id]),['class'=>'btn btn-link']);
                        },
                    "format" => "raw"
                ]*/
                [
                    "class" => '\kartik\grid\ActionColumn',
                    'header' => '',
                    'template' => '{delete}',
                    'width' => '40px'
                ]
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 设备列表</h3>',
                'type'=>'default',
                'before'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 刷新列表', ['index'], ['class' => 'btn btn-info']),
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>