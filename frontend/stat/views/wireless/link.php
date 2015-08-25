<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-1.下午8:37
 * Description: 链路信息
 */
use yii\helpers\Html;
use kartik\grid\GridView;
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

?>
<div class="device-info-view" style="width:780px;height:600px;" id="wireless_link">

</div>
