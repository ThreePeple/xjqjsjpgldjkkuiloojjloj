<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-1.下午8:37
 * Description: 链路信息
 */
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<link type="text/css" rel="stylesheet" href="/css/node_detail_popup.css"></link>
<div class="device-info-view">

    <h4><?= Html::encode("链路信息") ?></h4>
    <?=
    GridView::widget([
        "dataProvider"=>$dataProvider,
        "pjax" => true,
        "striped" => false,
        "columns" => [
            [
                "label" => "左接口",
                "value" => "leftIfDesc",
            ],
            [
                "label" =>"左接口描述",
                "value" => "leftIfDesc"
            ],
            [
                "label" => "右接口",
                "value" => "rightIfDesc",
            ],
            [
                "label" =>"链路右接口描述",
                "value" => "rightIfDesc"
            ],
            [
                "label" => "接收速率",
                "value" => 'linkspeed'
            ],
            [
                "label" => "带宽",
                "value" => "bandWidth"
            ],
        ],
        "export"=>false
    ]);
    ?>
</div>