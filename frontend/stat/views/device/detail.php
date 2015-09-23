<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-28.下午11:46
 * Description:
 */

$this->registerJsFile("/js/h_collapse.js",["depends"=>'frontend\assets\AppAsset']);
$this->registerCssFile("/css/h_collapse.css",["depends"=>'frontend\assets\AppAsset']);

$js = <<<JS
        $("#refresh_perf").on("click",function(){
            $.ajax({
                url:'/stat/device/perf?id={$model->id}',
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


<div class="item_box box10 h_collapse_container" style="margin-top: 50px;">
    <div class="item_box_wp">
        <div class="voice_2">
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
                        <?=$this->render("interface",["data"=>$interfaceProvider])?>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>