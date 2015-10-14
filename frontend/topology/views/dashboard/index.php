<?php

$this->registerCssFile('/css/popuppanel.css'); 
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);

$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/echarts/build/dist/echarts-all.js',['depends'=>'frontend\assets\AppAsset']);


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

//$this->registerJsFile('/js/jQuery.marquee/jquery.marquee.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/marquee/lib/jquery.marquee.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerCssFile('/js/marquee/css/jquery.marquee.css',['depends'=>'frontend\assets\AppAsset']);


$css = <<<CSS
body{
    background-color: rgb(37,37,37) !important;
}
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
    bottom: 90px;
}
.buidling-editor-container text.title {
    display: none;
}
.main{
    height: 940px;
}
svg.ZSYFCEditor { 
    left: auto;
    top: auto;
    right: 0 !important;
    bottom: 0 !important;
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
    width: 180px;
    height:200px;
    overflow: hidden; 
    color:#8DFFB5;
    font-size: 20px;
    background-color: #000000;
}
.marquee th,
.marquee td{
    padding: 3px 5px;
}
CSS;
$this->registerCss($css);

$js = <<<JS

    var mq = $('#marquee');
    function reloadData(){
        $.ajax({
            url:'/topology/dashboard/get-marquee-data',
            type:'get',
            dataType: 'html',
            success:function(htm){
                mq.html(htm);
                marquee()
            }
        })
    }
    var counter = 0;
    function marquee(){
        if(counter){
            $('#marquee').marquee('update')
        }else{
            mq.marquee({
                aftershow:function(ul,li){
                    var count = $(ul).find('li').length;
                    var index = $("li",ul).index(li);
                    //console.log(count,index);
                    if(count == (index+1)){
                        reloadData();
                    }
                },
                pauseOnHover:true
            });
        }
    }
reloadData();
JS;
$this->registerJs($js);
?>
<div class="row" style="margin-top:50px;min-height: 700px;position:relative;">
    <div class="col-md-3" style="margin-top: 10px;position:relative; z-index:2;padding-top: 60px;">
        <div class="col-md-12">
            <div class="box" style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">设备统计</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="device_status" style="width:100%;height:200px;">

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;">
                <div class="box-header">
                    <h3 class="box-title">告警级别</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="events_levels" style="width:100%; height: 200px;">
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-12">
            <div class="box"  style="background: none;border:0;">
                <div class="box-header">
                    <h3 class="box-title">设备性能指标</h3>
                </div>
                <div class="box-body" id="itemType" style="width:300px; height: 200px;">
                    <ul class="marquee" id="marquee" style="width: 240px;height:200px;border:0;background-color:
                    transparent;">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
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
