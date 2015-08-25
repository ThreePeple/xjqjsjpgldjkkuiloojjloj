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

<div class="device-info-view" style="width:760px;height:600px;" id="wireless_link">
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
