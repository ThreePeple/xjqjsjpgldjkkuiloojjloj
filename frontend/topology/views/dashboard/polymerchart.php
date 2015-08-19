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

CSS;

$this->registerCss($css);



?>
<div style="row margin-top: 50px">
    <div class="col-md-3">
        <div class="col-md-12">
            <div class="box" style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">核心交换机</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_type">
                    <?php
                        foreach($cores as $id=>$label){
                            echo \yii\helpers\Html::button($label,["class"=>"btn btn-default","value"=>$id,"onclick"=>"renderChart(".$id.")"]);
                        }
                    ?>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="col-md-9">
        <svg id="ZSYPolymerChart">
            <defs>
                <filter id="filter_blur" x="0" y="0">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="1" />
                </filter>
            </defs>
        </svg>
    </div>
</div>

