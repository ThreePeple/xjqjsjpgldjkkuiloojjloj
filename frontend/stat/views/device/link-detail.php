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
            //["label" => "链路名称","attribute"=>"id"],
            //["label" => "链路类型","attribute"=>"type"],
            ["label" => "左接口","attribute"=>"left.label"],
            ["label" => "左接口描述","attribute"=>"leftIfDesc"],
            //["label" => "左接口别名","attribute"=>"id"],
            ["label" => "左接口接收速率","attribute"=>"leftInSpeed"],
            ["label" => "左接口发送速率","attribute"=>"leftOutSpeed"],
            //["label" => "左接口Allowed VLAN","attribute"=>"id"],
            ["label" => "右接口","attribute"=>"right.label"],
            ["label" => "右接口描述","attribute"=>"rightIfDesc"],
            ["label" => "右接口接收速率","attribute"=>"leftOutSpeed"],
            ["label" => "右接口发送速率","attribute"=>"leftInSpeed"],
        ]
    ])?>
</div>
<div>
<?php
    if(!empty($alarmDatas)){
        echo '<h4>告警信息</h4>';
        echo '<table class="table table-bordered detail-view">';
        foreach($alarmDatas as $data){
            echo '<tr><th>'.$data['deviceIp'].'</th><td>'.$data['alarmDesc'].'</td></tr>';
        }
        echo '</table>';
    }
?>
    </div>