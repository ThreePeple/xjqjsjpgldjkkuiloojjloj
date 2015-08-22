<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/18
 * Time: 12:37
 */

$this->registerJsFile('/js/d3.min.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYPolymerChart.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ploymer.js',["depends"=> 'frontend\assets\AppAsset']);

$css = <<<CSS
			html,body{
				background-color: #252525;
			}
			svg{
			    font-size: 12px;
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
				fill: gray;
				stroke: gray;
				stroke-width: 1px;
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
				stroke: gray;
				stroke-width: 1px;
			}
			.ZSYPolymerChart .node.hover text{
				fill: #fff;
			}
			.ZSYPolymerChart .node.hover circle{
				fill: #fff;
				filter: url(#filter_blur);
				-webkit-transform: scale(1.38);
			}
			.ZSYPolymerChart .link-path.hover{
				stroke: #fff;
				stroke-width: 1px;
			}

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

$group = $groups[1];
$id1 = isset($group[0])?$group[0]:0;
$id2 = isset($group[1])?$group[1]:0;

$js = <<<JS
    renderChart($id1,$id2)
JS;
$this->registerJs($js);
?>
<div class="box" style="background: none;position: absolute;z-index:100;margin-top: 100px;width: 180px;">
    <div class="box-header">
        <h3 class="box-title">聚汇交换机</h3>
    </div><!-- /.box-header -->
    <div class="box-body" id="events_type">
        <?php
        foreach($polymers as $id=>$item){
            $label = $item["label"];
            $group = $groups[$item["group"]];
            $id1 = isset($group[0])?$group[0]:0;
            $id2 = isset($group[1])?$group[1]:0;
            $css = $item["group"]==1? "btn-default" : "btn-primary";
            echo \yii\helpers\Html::button($label,["class"=>"btn $css","style"=>"margin:5px;","id"=>$item["id"],"group"=>$item["group"],"onclick"=>"changeCore(".$item["group"].",".$id1.",".$id2.")"]);
        }
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

