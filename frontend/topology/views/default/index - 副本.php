<?php

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/building.css');
$this->registerCssFile('/css/wireless-network.css');
$this->registerCssFile('/css/wire-network.css');
$this->registerCssFile('/css/app.css');

$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/building.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/wireNetwork.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/wirelessNetwork.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/highcharts.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/highcharts-more.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/topology.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/topology.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/app.js',['depends'=>'frontend\assets\AppAsset']);

$css = <<<CSS
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
?>
<div class="row" style="margin-top:50px;min-height: 700px">
    <div class="col-md-3" style="margin-top: 10px">
        <div class="col-md-12">
            <div class="box" style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">事件按类型分类</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_type">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">当前全部事件统计</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_levels">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">系统运行状态快照</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="runtime">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="building" id="buildingHolder">
        </div>
    </div>
</div>
<div class="row">
    <h4 style="color:white">有线网络拓扑</h4>
    <div class="wire-network" id="wireNetworkHolder">
    </div>
</div>
<div class="row">
    <h4 style="color:white">无线网络拓扑</h4>

    <div class="col-md-9">
        <div class="wireless-network" id="wirelessNetworkHolder">
        </div>
    </div>
    <div class="col-md-3">

    </div>
</div>
<div class="row">
    <h4 style="color:white">交换机组</h4>
    <div class="col-md-12" id="hubHolder">
        <script src="/js/app.js"></script>
    </div>
</div>
