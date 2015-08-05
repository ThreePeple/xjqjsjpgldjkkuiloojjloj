<?php

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/wire-network.css');

$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/wireNetwork.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);

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
    <div class="wire-network" id="wireNetworkHolder">
    	<a data-area-id="a" title="A区" href="#A"></a>
    	<a data-area-id="b" title="B区" href="#B"></a>
    	<a data-area-id="c" title="C区" href="#C"></a>
    	<a data-area-id="d" title="D区" href="#D"></a>
    	<a data-area-id="e" title="E区" href="#E"></a>
    	<a data-area-id="f" title="F区" href="#F"></a>
    </div>
</div>