<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-1.下午8:37
 * Description: 链路信息
 */
use yii\helpers\Html;
use kartik\grid\GridView;


if($categoryId != 1003){
    $js = <<<JS
var myChart = echarts.init(document.getElementById("wireless_link"));

   var option = {
            title : {
                text: '设备链路信息',
                x:'center',
                y:'top'
            },
            tooltip : {
                trigger: 'item',
                formatter: function (params) {
                    if (params.indicator2) {    // is edge
                        return params.indicator2 + ' ' + params.name + ' ' + params.indicator;
                    } else {    // is node
                        return params.name
                    }
                }
            },
            toolbox: false,
            legend: false,
            series : [
                {
                    name: '无线设备链路',
                    type:'chord',
                    sort : 'ascending',
                    sortSub : 'descending',
                    ribbonType: false,
                    radius: '60%',
                    itemStyle : {
                        normal : {
                            label : {
                                rotate : true
                            },
                            lineStyle:{
                                color: '#fff'
                            },
                            color: 'green'
                        }
                    },
                    minRadius: 7,
                    maxRadius: 20,
                    // 使用 nodes links 表达和弦图
                    nodes: $nodes,
                    links: $links
                }
            ]
        };

        myChart.setOption(option)
        window.onresize = myChart.resize();
JS;
    $this->registerJs($js);
}

?>

<div class="device-info-view" style="width:760px;height:400px;" id="wireless_link">
<?php
if($categoryId == 1003){
 ?>
    <h1><?= Html::encode("设备相关链路信息") ?></h1>
    <?=
    GridView::widget([
        "dataProvider"=>$apProvider,
        "pjax" => true,
        "columns" => [
            [
                "label" => "ID",
                "value" => "id",
            ],
            [
                "label" =>"标签",
                "value" => "label"
            ],
            [
                "label" =>"系统名称",
                "value" => "sysName"
            ],
            [
                "label" => "状态",
                "value" =>  function($model){
                    $statusLabel = '正常';
                    switch($model->status){
                        case 1:
                            $statusLabel="正常";
                            break;
                        case 2:
                            $statusLabel="告警";
                            break;
                        default:
                    }
                    return $statusLabel;
                }
            ],
            [
                "label" => "IP",
                "value" => "ipAddress"
            ],
            [
                "label" => "物理位置",
                "value" => "location"
            ],

        ],
        "export"=>false
    ]);
    ?>
    <?php
}
?>
</div>
<?php
if($categoryId != 1003){
    foreach($linkModels as $model){
        echo '<div class="view">';
        echo '<h4>'. ($model->left ? $model->left->ip : '') .'~'.($model->right ? $model->right->ip : '').'</h4>';
         echo \yii\widgets\DetailView::widget([
            'model' => $model,
            "options" => [
                "class" => 'table table-bordered detail-view'
            ],
            'attributes' => [
                [
                    "label" => "左接口",
                    "value" => ($model->left ? $model->left->label : ''),
                ],
                [
                    "label" =>"左接口描述",
                    "value" => $model->leftIfDesc
                ],
                ["label" => "左接口接收速率(bps)","attribute"=>"leftInSpeed"],
                ["label" => "左接口发送速率(bps)","attribute"=>"leftOutSpeed"],
                [
                    "label" => "右接口",
                    "value" => ($model->right ? $model->right->label : ''),
                ],
                [
                    "label" =>"链路右接口描述",
                    "value" => $model->rightIfDesc
                ],
                ["label" => "右接口接收速率(bps)","attribute"=>"rightInSpeed"],
                ["label" => "右接口发送速率(bps)","attribute"=>"rightOutSpeed"],
                [
                    "label" => "带宽",
                    "value" => $model->bandWidth
                ],
            ],
        ]);
        echo '</div>';
    }
}
?>
