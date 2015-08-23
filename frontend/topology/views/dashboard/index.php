<?php

$this->registerCssFile('/css/popuppanel.css'); 
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);

$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/highcharts.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/highcharts-more.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/topology.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);

$this->registerJsFile('/js/ZSYFCEditorUtil.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCNodeData.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCShapeMaker.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCObjectCollector.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCLinePathPosition.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCHelperPosition.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCLinkline.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCEditor.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/jQuery.marquee/jquery.marquee.js',['depends'=>'frontend\assets\AppAsset']);


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
.buidling-editor-container{
    border: none;
    position: absolute;
    right: 0;
    top: 120px;
}
.buidling-editor-container text.title {
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
.ZSYFCEditor image{
    opacity: 0.666
}
.nodeDetail .popup_content{
    max-height: 350px;
    min-width: 330px;
    overflow: auto;
}


.marquee {
  width: 90%;
  overflow: hidden;
  /*
  border: 1px solid #ccc;
  background: #ccc;
  */
  margin-top: 10px;
  color:#8DFFB5;
  font-size: 20px;
}
CSS;
$this->registerCss($css);

$js = <<<JS
    var \$mq = $('.marquee');
    function reloadData(){
        $.ajax({
            url:'/topology/dashboard/get-marquee-data',
            type:'get',
            dataType: 'html',
            success:function(htm){
                \$mq.html(htm);
                \$mq.marquee('destroy')
                marquee()
            }
        })
    }
    var counter = 0;
    function marquee(){
        \$mq.bind('finished', function(){
            reloadData();
        })
        .marquee({
            duration: 5000,
            duplicated: false,
            pauseOnHover: true
        })
    }
    reloadData();

/*
$('.marquee').marquee({
    //speed in milliseconds of the marquee
    duration: 5000,
    //gap in pixels between the tickers
    gap: 50,
    //time in milliseconds before the marquee will start animating
    delayBeforeStart: 0,
    //'left' or 'right'
    direction: 'left',
    //true or false - should the marquee be duplicated to show an effect of continues flow
    duplicated: false
});*/
JS;
$this->registerJs($js);
?>
<div class="row" style="margin-top:50px;min-height: 700px">
    <div class="col-md-3" style="margin-top: 10px">
        <div class="col-md-12">
            <div class="box" style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">设备统计</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="device_status">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">告警级别</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_levels">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">告警类型</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="runtime">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="marquee">jQuery marquee is the best <b>marquee</b> plugin in the world</div>
        <div class="buidling-editor-container">
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

</div>
