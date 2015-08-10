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
	.wire-network{
		position: relative;
	}
	.wire-network a{
		-webkit-transform: rotate(62deg) translate(129px, -159px); 
		position: absolute;
		left: 0;
		top: 0;
		width: 123px;
		height: 48px; 
		z-index: 2;
	}

	.wire-network a[data-area-id="a"]{
		-webkit-transform: translate(103px, 137px);
	}

	.wire-network a[data-area-id="b"]{
		  -webkit-transform: translate(1036px, 175px);
	}

	.wire-network a[data-area-id="c"]{
	  -webkit-transform: translate(1180px, 270px);
	  width: 186px;
	}

	.wire-network a[data-area-id="d"]{
	  -webkit-transform: translate(1247px, 572px);
	  width: 200px;
	}

	.wire-network a[data-area-id="e"]{
		  -webkit-transform: translate(1226px, 866px);
	}

	.wire-network a[data-area-id="f"]{
  -webkit-transform: translate(125px, 661px);
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
    <div class=" wireless-editor-container" id="wireNetworkHolder">
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