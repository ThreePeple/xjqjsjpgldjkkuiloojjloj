<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/18
 * Time: 12:37
 */

$this->registerCssFile("/css/popuppanel.css",["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile("/js/popuppanel.js",["depends"=> 'frontend\assets\AppAsset']);

$this->registerJsFile('/js/d3.min.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYPolymerChart.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ploymer.js',["depends"=> 'frontend\assets\AppAsset']);

$css = <<<CSS
html,body{
	background-color: #252525;
}
svg{
    font-size: 12px;
    margin: 0 auto 0;
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
.box{
  color: #fff;
  position: relative;
  border-radius: 3px; 
  border: 1px solid #454545;
  margin-bottom: 20px;
  width: 100%;
  box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.box-header{
    color: #939393;
}
.nodeDetail .popup_content{
	max-height: 350px;
	min-width: 330px;
	overflow: auto;
}

.fixedbox{
	background: none;position: fixed;
	z-index:100;margin-top: 100px;
	width: 95px;
	box-shadow: 0 0 3px 1px #111;
	background-color: #363636;
}
.fixedbox .box-header{
	padding: 6px 10px;
}
.fixedbox .box-body{
	padding: 2px 10px;
}
.fixedbox .box-body .vs{
	text-align: center;
	position: relative;
	margin: -6px 0;
	display: none;
}
.fixedbox .box-body .group{
	background-color: rgba(255,255,255, 0.2);
	margin: 5px 0;
	border-radius: 5px;
	float:left;
}
.fixedbox .box-body .splitter{
	margin: 10px 0;
}
.ZSYPolymerChart_rendered .left .node g.text{      
	-webkit-transform-origin: 50% 50%;
    -webkit-transform: rotate(180deg);
}

CSS;

$this->registerCss($css);

/*
$group = $groups[1];
$id1 = isset($group[0])?$group[0]:0;
$id2 = isset($group[1])?$group[1]:0;
*/
$js = <<<JS

    renderChart(681,731)
JS;
$this->registerJs($js);
?>
<div class="box fixedbox">
    <div class="box-header" style="text-align: center">
        <h3 class="box-title">区域</h3>
    </div><!-- /.box-header -->
    <div class="box-body" id="events_type">
        <div class="group">
            <?=\yii\helpers\Html::button('A/B区',["class"=>"btn btn-default","style"=>"margin:5px;","id"=>681,"group"=>1,"onclick"=>"changeCore(1,681,731)"]);?>

        </div>
        <div class="group">
            <?= \yii\helpers\Html::button('C/D区',["class"=>"btn btn-primary","style"=>"margin:5px;","id"=>766,"group"=>2,"onclick"=>"changeCore(2,766,731)"]);?>

        </div>
        <?php
        /*
	        $currentIndex = 0;
	        foreach($polymers as $id=>$item){
	        	$currentIndex++;
	            $label = $item["label"];
	            $group = $groups[$item["group"]];
	            $id1 = isset($group[0])?$group[0]:0;
	            $id2 = isset($group[1])?$group[1]:0;
	            $css = $item["group"]==1? "btn-default" : "btn-primary";

	            if( $currentIndex % 2 == 1 ){
	            	echo "<div class='group'>";
	            }
	            
	            echo \yii\helpers\Html::button($label,["class"=>"btn $css","style"=>"margin:5px;","id"=>$item["id"],"group"=>$item["group"],"onclick"=>"changeCore(".$item["group"].",".$id1.",".$id2.")"]);
	            
	            if( $currentIndex % 2 == 1 ){
	            	echo "<div class='vs'>VS.</div>";
	            } else
	            	if( $currentIndex % 2 == 0 ){
	            		echo "</div>";
	            	}
	        }
        */
        ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<div style=" margin-top: 50px">
    <svg id="ZSYPolymerChart">
        <defs>
            <filter id="filter_blur" x="0" y="0">
                <feGaussianBlur in="SourceGraphic" stdDeviation="1" />
            </filter>
        </defs>
    </svg>
</div>

