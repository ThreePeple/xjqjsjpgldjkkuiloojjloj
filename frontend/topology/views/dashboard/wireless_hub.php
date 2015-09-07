<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/18
 * Time: 12:37
 */

$this->registerJsFile('/js/echarts/build/dist/echarts-all.js',['depends'=>'frontend\assets\AppAsset']);


$this->registerCssFile("/css/popuppanel.css",["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile("/js/popuppanel.js",["depends"=> 'frontend\assets\AppAsset']);

$this->registerCssFile('/css/style.css');
$this->registerJsFile('/js/wireless_ploymer.js',["depends"=> 'frontend\assets\AppAsset']);

/*
$this->registerJsFile('/js/d3.min.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYPolymerChart.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile('/js/wireless_ploymer.js',["depends"=> 'frontend\assets\AppAsset']);

$css = <<<CSS
html,body{
	background-color: #252525;
}
svg{
    font-size: 12px;
    margin: 90px auto 0;
    display: block;
}
.ZSYPolymerChart .shape.shape0{
	fill: #60c0dd;
}
.ZSYPolymerChart .shape.shape1{
	fill: #d9c771;
}
.ZSYPolymerChart .polymer text{
	  font-family: "微软雅黑";
}
.ZSYPolymerChart .node{
	cursor: default;
}
.ZSYPolymerChart circle{
	fill: green;
	stroke: green;
	stroke-width: 1px;
}
.ZSYPolymerChart [data-status="2"] circle{
	fill: red;
	stroke: red;
}
.ZSYPolymerChart .node text{
	fill: gray;
	font-size: 15px;
}
.ZSYPolymerChart .node circle{
	-webkit-transform: scale(1);
}
.ZSYPolymerChart .link-path{
	fill: transparent;
	stroke: green;
	stroke-width: 2px;
	stroke-linecap: round;
}
.ZSYPolymerChart .link-path[data-status="2"]{
	stroke: red;
}

.ZSYPolymerChart .node.hover text{
	fill: #fff;
}
.ZSYPolymerChart .node.hover circle{
	fill: rgb(30, 255, 30);
	filter: url(#filter_blur);
	-webkit-transform: scale(1.38);
}
.ZSYPolymerChart .node.hover[data-status="2"] circle{
	fill: rgb(255, 60, 60);
}

.ZSYPolymerChart .link-path.hover{
	stroke: rgb(30, 255, 30);
	stroke-width: 2px;
} 
.ZSYPolymerChart .link-path[data-status="2"].hover{
	stroke: rgb(255,100,100);
}

.nodeDetail .popup_content{
	max-height: 350px;
	min-width: 330px;
	overflow: auto;
}


CSS;

$this->registerCss($css);


$js = <<<JS

    renderChart('/topology/dashboard/ajax-wireless-hub',{id1:3809,id2:3810})
JS;
$this->registerJs($js);
?>

<div style=" margin-top: 50px">
    <svg id="ZSYPolymerChart">
        <defs>
            <filter id="filter_blur" x="0" y="0">
                <feGaussianBlur in="SourceGraphic" stdDeviation="1" />
            </filter>
        </defs>
    </svg>
</div>

*/

$css = <<<CSS
html,body{
	background-color: #252525;
}
CSS;
$this->registerCss($css);
$js = <<<JS

    $.ajax({
        url:'/topology/dashboard/ajax-wireless-ehub',
        type:'post',
        data: {'id1':3809,"id2":3810},
        dataType:'json',
        success:function(data){
            if(data.status==1){
                renderEChart(data.data.nodes,data.data.links)
            }
        }
    })
JS;
$this->registerJs($js);

?>

<div class="row">
    <div class="col-md-12" style="margin-top: 60px; height: 950px;" id="wireless_hub"></div>
</div>

