<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/18
 * Time: 10:30
 */


?>
<div class="device-info-view view">
    <h4>链路信息</h4>
    <?=\yii\widgets\DetailView::widget([
        "model" => $model,
        "options" => [
            "class" => "table table-bordered detail-view"
        ],
        "attributes"=>[
            ["label" => "链路名称","attribute"=>"id"],
            ["label" => "链路类型","attribute"=>"type"],
            ["label" => "左接口","attribute"=>"leftDevice"],
            ["label" => "左接口描述","attribute"=>"leftIfDesc"],
            ["label" => "左接口别名","attribute"=>"id"],
            ["label" => "左接口WLAN类型","attribute"=>"id"],
            ["label" => "左接口Allowed VLAN","attribute"=>"id"],
            ["label" => "右接口","attribute"=>"rightDevice"],
            ["label" => "右接口描述","attribute"=>"rightIfDesc"],
            ["label" => "右接口别名","attribute"=>"id"],
            ["label" => "链路带宽","attribute"=>"bandWidth"],
        ]
    ])?>
</div>