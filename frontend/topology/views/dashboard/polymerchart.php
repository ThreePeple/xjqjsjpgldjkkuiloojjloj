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


$js = <<<JS
/*
var _DATA = {
				"groups":{
					"group1": [
						{ "id": "ida0", "label": "label 0"},{ "id": "ida1", "label": "label 1"},{ "id": "ida2", "label": "label 2"},{ "id": "ida3", "label": "label 3"},{ "id": "ida4", "label": "label 4"},{ "id": "ida5", "label": "label 5"},{ "id": "ida6", "label": "label 6"},{ "id": "ida7", "label": "label 7"},{ "id": "ida8", "label": "label 8"},{ "id": "ida9", "label": "label 9"},{ "id": "ida10", "label": "label 10"},{ "id": "ida11", "label": "label 11"},{ "id": "ida12", "label": "label 12"},{ "id": "ida13", "label": "label 13"},{ "id": "ida14", "label": "label 14"},{ "id": "ida15", "label": "label 15"},{ "id": "ida16", "label": "label 16"},{ "id": "ida17", "label": "label 17"},{ "id": "ida18", "label": "label 18"},{ "id": "ida19", "label": "label 19"},{ "id": "ida20", "label": "label 20"},{ "id": "ida21", "label": "label 21"},{ "id": "ida22", "label": "label 22"},{ "id": "ida23", "label": "label 23"},{ "id": "ida24", "label": "label 24"},{ "id": "ida25", "label": "label 25"},{ "id": "ida26", "label": "label 26"},{ "id": "ida27", "label": "label 27"},{ "id": "ida28", "label": "label 28"},{ "id": "ida29", "label": "label 29"},{ "id": "ida30", "label": "label 30"}
					],
					"group2": [
						{ "id": "idb0", "label": "label 0"},{ "id": "idb1", "label": "label 1"},{ "id": "idb2", "label": "label 2"},{ "id": "idb3", "label": "label 3"},{ "id": "idb4", "label": "label 4"},{ "id": "idb5", "label": "label 5"},{ "id": "idb6", "label": "label 6"},{ "id": "idb7", "label": "label 7"},{ "id": "idb8", "label": "label 8"},{ "id": "idb9", "label": "label 9"},{ "id": "idb10", "label": "label 10"},{ "id": "idb11", "label": "label 11"},{ "id": "idb12", "label": "label 12"},{ "id": "idb13", "label": "label 13"},{ "id": "idb14", "label": "label 14"},{ "id": "idb15", "label": "label 15"},{ "id": "idb16", "label": "label 16"},{ "id": "idb17", "label": "label 17"},{ "id": "idb18", "label": "label 18"},{ "id": "idb19", "label": "label 19"},{ "id": "idb20", "label": "label 20"},{ "id": "idb21", "label": "label 21"},{ "id": "idb22", "label": "label 22"},{ "id": "idb23", "label": "label 23"},{ "id": "idb24", "label": "label 24"},{ "id": "idb25", "label": "label 25"},{ "id": "idb26", "label": "label 26"},{ "id": "idb27", "label": "label 27"},{ "id": "idb28", "label": "label 28"},{ "id": "idb29", "label": "label 29"},{ "id": "idb30", "label": "label 30"},{ "id": "idb31", "label": "label 31"},{ "id": "idb32", "label": "label 32"},{ "id": "idb33", "label": "label 33"},{ "id": "idb34", "label": "label 34"},{ "id": "idb35", "label": "label 35"},{ "id": "idb36", "label": "label 36"},{ "id": "idb37", "label": "label 37"},{ "id": "idb38", "label": "label 38"},{ "id": "idb39", "label": "label 39"},{ "id": "idb40", "label": "label 40"},{ "id": "idb41", "label": "label 41"},{ "id": "idb42", "label": "label 42"},{ "id": "idb43", "label": "label 43"},{ "id": "idb44", "label": "label 44"},{ "id": "idb45", "label": "label 45"},{ "id": "idb46", "label": "label 46"},{ "id": "idb47", "label": "label 47"},{ "id": "idb48", "label": "label 48"},{ "id": "idb49", "label": "label 49"},{ "id": "idb50", "label": "label 50"}
					]
				},
				"polymers": [
					{
						"id": "p1",
						"label": "聚汇交换机1",
						"children": [
							"group1:ida0","group1:ida1","group1:ida2","group1:ida3","group1:ida4","group1:ida5","group1:ida6","group1:ida7","group1:ida8","group1:ida9","group1:ida10","group1:ida11","group1:ida12","group1:ida13","group1:ida14","group1:ida15","group1:ida16","group1:ida17","group1:ida18","group1:ida19","group1:ida20","group1:ida21","group1:ida22","group1:ida23","group1:ida24","group1:ida25","group1:ida26","group1:ida27","group1:ida28","group1:ida29","group1:ida30",
							"group2:idb0","group2:idb1","group2:idb2","group2:idb3","group2:idb4","group2:idb5","group2:idb6","group2:idb7","group2:idb8","group2:idb9","group2:idb10","group2:idb11","group2:idb12","group2:idb13","group2:idb14","group2:idb15","group2:idb16","group2:idb17","group2:idb18","group2:idb19","group2:idb20","group2:idb21","group2:idb22","group2:idb23","group2:idb24","group2:idb25","group2:idb26","group2:idb27","group2:idb28","group2:idb29","group2:idb30","group2:idb31","group2:idb32","group2:idb33","group2:idb34","group2:idb35","group2:idb36","group2:idb37","group2:idb38","group2:idb39","group2:idb40","group2:idb41","group2:idb42","group2:idb43","group2:idb44","group2:idb45","group2:idb46","group2:idb47","group2:idb48","group2:idb49","group2:idb50"
						]
					},
					{
						"id": "p2",
						"label": "聚汇交换机2",
						"children": [
							"group1:ida0","group1:ida1","group1:ida2","group1:ida3","group1:ida4","group1:ida5","group1:ida6","group1:ida7","group1:ida8","group1:ida9","group1:ida10","group1:ida11","group1:ida12","group1:ida13","group1:ida14","group1:ida15","group1:ida16","group1:ida17","group1:ida18","group1:ida19","group1:ida20","group1:ida21","group1:ida22","group1:ida23","group1:ida24","group1:ida25","group1:ida26","group1:ida27","group1:ida28","group1:ida29","group1:ida30",
							"group2:idb0","group2:idb1","group2:idb2","group2:idb3","group2:idb4","group2:idb5","group2:idb6","group2:idb7","group2:idb8","group2:idb9","group2:idb10","group2:idb11","group2:idb12","group2:idb13","group2:idb14","group2:idb15","group2:idb16","group2:idb17","group2:idb18","group2:idb19","group2:idb20","group2:idb21","group2:idb22","group2:idb23","group2:idb24","group2:idb25","group2:idb26","group2:idb27","group2:idb28","group2:idb29","group2:idb30","group2:idb31","group2:idb32","group2:idb33","group2:idb34","group2:idb35","group2:idb36","group2:idb37","group2:idb38","group2:idb39","group2:idb40","group2:idb41","group2:idb42","group2:idb43","group2:idb44","group2:idb45","group2:idb46","group2:idb47","group2:idb48","group2:idb49","group2:idb50"
						]
					}
				]

			};*/
renderChart(885)
JS;
$this->registerJs($js);


?>
<div style="margin-top: 50px">
    <svg id="ZSYPolymerChart">
        <defs>
            <filter id="filter_blur" x="0" y="0">
                <feGaussianBlur in="SourceGraphic" stdDeviation="1" />
            </filter>
        </defs>
    </svg>
</div>

