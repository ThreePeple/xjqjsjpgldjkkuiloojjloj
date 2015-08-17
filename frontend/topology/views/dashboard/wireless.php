<?php

use yii\helpers\Url;

$this->registerCssFile('/css/popuppanel.css'); 
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);


$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/topology_wireless.js',['depends'=>'frontend\assets\AppAsset']);
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
	.wireless-network{
		position: relative;
	}
	.wireless-network a{ 
		-webkit-transform: rotate(62deg) translate(129px, -159px); 
		position: absolute;
		left: 0;
		top: 0;
		width: 123px;
		height: 48px; 
		z-index: 2;
	}

	.wireless-network a[data-area-id="a"]{
		-webkit-transform: translate(158px, 194px)rotate(26deg);
	}

	.wireless-network a[data-area-id="b"]{
		  -webkit-transform: translate(2px, 480px)rotate(25deg);
	}

	.wireless-network a[data-area-id="c"]{
	  -webkit-transform: translate(152px, 577px)rotate(25deg);
	  width: 186px;
	}

	.wireless-network a[data-area-id="d"]{
	  -webkit-transform: translate(368px, 679px)rotate(25deg);
	  width: 200px;
	}

	.wireless-network a[data-area-id="e"]{
		  -webkit-transform:translate(598px, 774px)rotate(0deg);
	}

	.wireless-network a[data-area-id="f"]{
  -webkit-transform: translate(1000px, 211px)rotate(27deg);
	}


	.buidling-editor-container text.title{
		display: none;
	}
	.nodeDetail .popupBody ul{
	    margin: 0 10px;
	    padding: 0;
	}	
	.nodeDetail .popupBody li {
		color: #ababab;
		margin: 3px 0;
		white-space: nowrap;
		list-style: none;
	}
	.nodeDetail .popupBody li span{
		font-weight: bold;
		margin-right: 10px;
		color: #fff;
	}
</style>
<script type="text/single-html-template" id="switch_node_detail">
    <ul> 
        <li><span>名称:</span>{name}</li>
        <li><span>楼层:</span>{floor}</li> 
        <li><span>ip地址:</span>{ip}</li>
        <li><span>设备厂商:</span>{vendors}</li>
        <li><span>设备类型:</span>{deviceType}</li>
    </ul>
</script>
<div class="row">
    <div class="wireless-network wireless-editor-container" id="wireNetworkHolder">
    	<a data-area-id="a" title="A区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>1])?>"></a>
    	<a data-area-id="b" title="B区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>4])?>"></a>
    	<a data-area-id="c" title="C区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>5])?>"></a>
    	<a data-area-id="d" title="D区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>6])?>"></a>
    	<a data-area-id="e" title="E区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>3])?>"></a>
    	<a data-area-id="f" title="F区" href="<?=Url::toRoute(['/topology/dashboard/device-area','area'=>2])?>"></a>
        <svg class="ZSYFCEditor" oncontextmenu="return false;" style="  background: url(/images/wireless_bg.png) no-repeat; margin-top: 50px;">
            <defs>
                <marker id="ZSYFCEditor_MarkerArrow" markerWidth="13" markerHeight="13" refx="9" refy="6" orient="auto">
                    <path d="M2,2 L2,11 L10,6 L2,2" style="fill: #000000;" />
                </marker>
            </defs>
            <g class="svg-container"></g>
        </svg>
    </div>
</div>