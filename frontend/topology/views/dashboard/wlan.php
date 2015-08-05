<?php

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/wire-network.css');

$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/wireNetwork.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);

?>

<div class="row">
    <h4 style="color:white">有线网络拓扑</h4>
    <div class="wire-network" id="wireNetworkHolder">
    </div>
</div>

