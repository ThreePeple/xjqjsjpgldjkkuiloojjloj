<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\WirelessDeviceInfo;
?>

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

<div class="row" >
    <div class="col-md-12">
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
           // "filterModel" => $searchModel,
            'pjax'=> true,
            "columns" => [
                [
                    "attribute" => "ip",
                    "width" =>"75px"
                ],
                [
                    "attribute" => "label",
                    "value" => function($model){
                        return Html::a($model->label,Url::toRoute(['/input/device/view',"id"=>$model->id]));
                    },
                    "format" => 'raw',
                ],
                [
                    "attribute" => "typeName",
                ],
                [
                    "label" => '<a href="javascript:void(0)">设备系列</a>',
                    'encodeLabel'=> false,
                    "attribute" => 'series',
                    "value" => "series.name",
                ],
                [
                    "label" => '<a href="javascript:void(0)">设备型号</a>',
                    'encodeLabel'=> false,
                    "attribute" => 'model',
                    "value" => 'model.name',
                ],

                [
                    "attribute" => "mask",
                ],
                [
                    "attribute" => "mac",
                ],
                //"phyCreateTime",
                [
                    'attribute'=>'status',
                    'vAlign'=>'middle',
                    'width'=>'90px',
                    'value'=>function ($model, $key, $index, $widget) {
                        return isset(WirelessDeviceInfo::$status_titles[$model->status])? WirelessDeviceInfo::$status_titles[$model->status] : WirelessDeviceInfo::$status_titles[0];
                    },
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>WirelessDeviceInfo::$status_titles,
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'选择状态','encode'=>false,'encodeSpaces'=>false],
                    'format'=>'raw',
                ],
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 无线设备查询</h3>',
                'type'=>'default',
                'before'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> 刷新列表', ['index'], ['class' => 'btn btn-info']),
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>
