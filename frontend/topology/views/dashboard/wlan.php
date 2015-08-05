<?php

use yii\helpers\Url;

$this->registerCssFile('/css/popuppanel.css'); 
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);


$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/topology_wlan.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);

$this->registerJsFile('/js/ZSYFCEditorUtil.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCNodeData.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCShapeMaker.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCObjectCollector.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCLinePathPosition.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCHelperPosition.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCLinkline.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCEditor.js',['depends'=>'frontend\assets\AppAsset']);

?>
<style>
	.wire-network{
		position: relative;
	}
	.wire-network a{
		-webkit-transform: rotate(62deg) translate(129px, -159px); 
		position: absolute;
		left: 0;
		top: 0;
		width: 177px;
		height: 408px;  
		z-index: 2;
	}

	.wire-network a[data-area-id="a"]{
		-webkit-transform: rotate(59deg) translate(215px, -118px);
		width: 277px;
		height: 308px; 
	}

	.wire-network a[data-area-id="b"]{
		-webkit-transform: rotate(59deg) translate(523px, -629px);
		height: 302px; 
	}

	.wire-network a[data-area-id="c"]{
		-webkit-transform: rotate(59deg) translate(688px, -745px);
		height: 343px; 
		width: 168px;
	}

	.wire-network a[data-area-id="d"]{
		-webkit-transform: rotate(59deg) translate(861px, -843px);
		height: 343px; 
		width: 168px;
	}

	.wire-network a[data-area-id="e"]{
		-webkit-transform: rotate(49deg) translate(1196px, -327px);
		height: 252px; 
		width: 207px;
	}

	.wire-network a[data-area-id="f"]{
		-webkit-transform: rotate(48deg) translate(567px, 294px);
		height: 440px; 
		width: 523px;
	}
	.buidling-editor-container text.title {
		display: none;
	}
</style>
<div class="row">
    <h4 style="color:white">有线网络拓扑</h4>
    <div class="wire-network buidling-editor-container wlan-editor-container" id="wireNetworkHolder">
    	<a data-area-id="a" title="A区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>1])?>"></a>
    	<a data-area-id="b" title="B区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>2])?>"></a>
    	<a data-area-id="c" title="C区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>3])?>"></a>
    	<a data-area-id="d" title="D区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>4])?>"></a>
    	<a data-area-id="e" title="E区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>5])?>"></a>
    	<a data-area-id="f" title="F区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>6])?>"></a>
        <svg class="ZSYFCEditor" oncontextmenu="return false;" >
            <defs>
                <marker id="ZSYFCEditor_MarkerArrow" markerWidth="13" markerHeight="13" refx="9" refy="6" orient="auto">
                    <path d="M2,2 L2,11 L10,6 L2,2" style="fill: #000000;" />
                </marker>
            </defs>
            <g class="svg-container"></g>
        </svg>
    </div>
</div>