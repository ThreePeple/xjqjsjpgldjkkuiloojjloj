<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-28.下午11:46
 * Description:
 */

$this->registerJsFile("/js/h_collapse.js",["depends"=>'frontend\assets\AppAsset']);
$this->registerCssFile("/css/h_collapse.css",["depends"=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/echarts/build/dist/echarts-all.js',['depends'=>'frontend\assets\AppAsset']);

$js = <<<JS
        $("#refresh_perf").on("click",function(){
            $.ajax({
                url:'/stat/wireless/perf?id={$model->id}',
                type:'GET',
                dataType:'html',
                success:function(_html){
                    $(".perf_view table").replaceWith($(_html).find("table"))
                }
            })
        })
JS;
$this->registerJs($js);
$this->title = "设备详情";
?>
<?php 
/*
<!--<link rel="stylesheet" type="text/css" href="/css/h_collapse.css">
<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/js/h_collapse.js"></script>-->
*/
?>
<div class="item_box box10 h_collapse_container" style="margin-top: 50px;">
    <div class="item_box_wp">
        <div class="voice_2 voice_3">
            <ul>
                <li class="li1" id="li1" >
                    <div class="fold" style="display: none;">
                        <span class="img"></span>
                        <span class="txt">设备详细信息</span>
                    </div>
                    <div class="unfold" style="display: block;">
                        <?=$this->render("view",[
                            "model" => $model
                        ])?>
                    </div>
                </li>
                <li class="li2" >
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">设备性能指标</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <?=$this->render("perf",[
                            "data" => $perflists,
                            "devId" => $model->id
                        ])?>
                    </div>
                </li>
                <li class="li3" >
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">设备告警信息</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <?=$this->render("alarm",[
                            "dataProvider" => $alarmProvider
                        ])?>
                    </div>
                </li>
                <li class="li4" >
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">设备接口信息</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <?=$this->render("interface",["data"=>$ifProvider])?>
                    </div>
                </li>
                <li class="li5" >
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">设备链路信息</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <?=$this->render("link",[
                            "nodes"=>json_encode($nodes),
                            "links" => json_encode($links),
                            "apProvider" =>$apProvider,
                            "categoryId"=>$model->categoryId
                        ])?>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>