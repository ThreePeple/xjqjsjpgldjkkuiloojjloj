<?php

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/building.css');

$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/building.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/highcharts.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/highcharts-more.js',['depends'=>'frontend\assets\AppAsset']);

$js = <<<JS
    $('#buildingHolder').zsyBuildingChart();
    $('#events_type').highcharts({
        credits: {
                    enabled: false
                },
        chart: {
            type: 'column',
            backgroundColor:'transparent',
            marginBottom: 50,
            allowOverlap:true,
            marginTop:20,
            height:200
        },
        plotOptions:{
            series:{
                groupPadding:0.05,
                pointPadding:0
            }
        },
        title:{
            text: ''
        },
        xAxis: {
            categories: ['有害程序', '网络攻击','信息破坏','信息安全','设备故障','安全预警','其他事件'],
            tickLength: 0
        },
        yAxis: {
            title: '',
            gridLineWidth: 0,
            labels:{ enabled:false}
        },
        legend: {
            enabled: false
        },
        series: [{
            data: [{
                name: 'Point 1',
                color: '#1C9AB6',
                y: 4
            }, {
                name: 'Point 2',
                color: '#4BB097',
                y: 18
            },{
                name: 'Point 2',
                color: '#4E4168',
                y: 13
            },{
                name: 'Point 2',
                color: '#4C7EAC',
                y: 5
            },{
                name: 'Point 2',
                color: '#A75A70',
                y: 8
            },{
                name: 'Point 2',
                color: '#8BAE3D',
                y: 11
            },{
                name: 'Point 2',
                color: '#DE6756',
                y: 6
            }],
            dataLabels:{
                enabled: true,
                align: 'top'
            }
        }]
    });
    $('#events_levels').highcharts({
        credits: {
                    enabled: false
                },
        legend: {
            enabled: false
        },
	    chart: {
	        polar: true,
	        height: 200,
            backgroundColor:'transparent',
            margin:0
	    },

	    title: {
	        text: ''
	    },
	    pane: {
	        startAngle: 0,
	        endAngle: 360
	    },
	    xAxis: {
	        tickInterval: 72,
	        min: 0,
	        max: 360,
	        labels: {
                enabled:false
            },
            gridLineWidth:0
	    },

	    yAxis: {
	        min: 0,
            lineWidth:0,
            gridLineWidth:0,
            max:20
	    },

	    plotOptions: {
	        series: {
	            pointStart: 0,
	            pointInterval: 72
	        },
	        column: {
	            pointPadding: 0,
	            groupPadding: 0
	        }
	    },

	    series: [{
	        type: 'column',
	        name: 'Column',
            data: [
                {color:'#9BCA62',y:18},
                {color:'#EDD777',y:14},
                {color:'#61C0DE',y:8},
                {color:'#067CCC',y:11},
                {color:'#F88464',y:4}
                 ],
	        pointPlacement: 'between'
	    }]
	});
    $('#runtime').highcharts({
        credits: {
                    enabled: false
                },
        chart: {
            type: 'bar',
            height: 150,
            backgroundColor:'transparent'
        },
        plotOptions:{
            series:{
                groupPadding:0.05,
                pointPadding:0
            }
        },
        title:{
            text: ''
        },
        xAxis: {
            categories: ['安全设备', '服务器','机房设备','客户端','应用系统','通讯设备','网络设备'],
            tickLength: 0
        },
        yAxis: {
            title: '',
            gridLineWidth: 0,
            labels:{ enabled:false}
        },
        legend: {
            enabled: false
        },
        series: [{
            data: [{
                name: 'Point 1',
                color: '#59BFA9',
                y: 2
            }, {
                name: 'Point 2',
                color: '#F95E4B',
                y: 10
            },{
                name: 'Point 2',
                color: '#59BFA9',
                y: 2
            },{
                name: 'Point 2',
                color: '#59BFA9',
                y:2
            },{
                name: 'Point 2',
                color: '#E99406',
                y: 8
            },{
                name: 'Point 2',
                color: '#FBDB51',
                y: 3
            },{
                name: 'Point 2',
                color: '#59BFA9',
                y: 4
            }],
            dataLabels:{
                enabled: true,
                align: 'top'
            }
        }]
    });
JS;

$this->registerJs($js);
$css = <<<CSS
.box{
  color: #fff;
  position: relative;
  border-radius: 3px;
  /* background: #ffffff; */
  border: 1px solid #454545;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.box-header{
    color: #939393;
}
CSS;
$this->registerCss($css);
?>
<div class="row" style="background: #363636;margin-top:50px ">
    <div class="col-md-3" style="margin-top: 10px">
        <div class="col-md-12">
            <div class="box" style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">事件按类型分类</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_type">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">当前全部事件统计</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_levels">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">系统运行状态快照</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="runtime">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="building" id="buildingHolder">
        </div>
    </div>
</div>

