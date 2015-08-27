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
<div class="item_box box10" style="margin-top: 50px;">
    <div class="item_box_wp">
        <div class="voice_2 voice_3">
            <ul>
                <li class="li1" id="li1" style="width: 780px;">
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
                <li class="li2" style="width: 100px;">
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
                <li class="li3" style="width: 100px;">
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
                <li class="li4" style="width: 100px;">
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">设备接口信息</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <?=$this->render("interface",["id"=>$id])?>
                    </div>
                </li>
                <li class="li5" style="width: 100px;">
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">设备链路信息</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <?=$this->render("link",[
                            "dataProvider"=>$links
                        ])?>
                    </div>
                </li>
    <?php /*            
                <!--
                <li class="li5" style="width: 100px;">
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">互联网通话</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <dl>
                            <dt><img src="images/img51.png"></dt>
                            <dd>
                                <b>互联网通话<a href="http://down.admin5.com/info/">查看接口文档&gt;&gt;</a></b>
                            </dd>
                            <dd>基于互联网纯网络通话，无运营商和地域限制，拥有更清晰的语音质量，支持语音三方密钥的加密传输</dd>
                        </dl>
                    </div>
                </li>
                <li class="li6" style="width: 100px;">
                    <div class="fold" style="display: block;">
                        <span class="img"></span>
                        <span class="txt">语音会议</span>
                    </div>
                    <div class="unfold" style="display: none;">
                        <dl>
                            <dt><img src="images/img52.png"></dt>
                            <dd>
                                <b>语音会议<a href="http://down.admin5.com/info/">查看接口文档&gt;&gt;</a></b>
                            </dd>
                            <dd>同时桥接多人基于IP、电话语音的会议服务，基于API控制会议时长、成员邀请、禁音、移除等功能。</dd>
                        </dl>
                    </div>
                </li>
                -->
        */
       ?>
            </ul>
        </div>
    </div>
</div>