<?php

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
		-webkit-transform: rotate(62deg) translate(48px, -159px); 
		position: absolute;
		left: 0;
		top: 0;
		width: 177px;
		height: 408px; 
	}

	.wire-network a[data-area-id="b"]{
		-webkit-transform: rotate(59deg) translate(275px, -475px);
		height: 264px; 
	}

	.wire-network a[data-area-id="c"]{
		-webkit-transform: rotate(59deg) translate(444px, -571px);
		height: 276px; 
		width: 128px;
	}

	.wire-network a[data-area-id="d"]{
		-webkit-transform: rotate(49deg) translate(692px, -545px);
		height: 252px; 
		width: 133px;
	}

	.wire-network a[data-area-id="e"]{
		-webkit-transform: rotate(55deg) translate(626px, -357px);
		height: 252px; 
		width: 133px;
	}

	.wire-network a[data-area-id="f"]{
		-webkit-transform: rotate(62deg) translate(286px, -20px);
		height: 366px; 
		width: 253px;
	}

</style>
<div class="row">
    <h4 style="color:white">有线网络拓扑</h4>
    <div class="wire-network buidling-editor-container wlan-editor-container" id="wireNetworkHolder">
    	<a data-area-id="a" title="A区" href="#A"></a>
    	<a data-area-id="b" title="B区" href="#B"></a>
    	<a data-area-id="c" title="C区" href="#C"></a>
    	<a data-area-id="d" title="D区" href="#D"></a>
    	<a data-area-id="e" title="E区" href="#E"></a>
    	<a data-area-id="f" title="F区" href="#F"></a>
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