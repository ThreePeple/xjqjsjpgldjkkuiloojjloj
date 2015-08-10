<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-22.下午10:06
 * Description:
 */
use yii\helpers\Url;

$dataUrl = Url::toRoute(['/stat/wireless/get-nodes','id'=>$id]);
$detailUrl = Url::toRoute(['/stat/wireless/get-detail']);
$js = <<<JS
    renderHub('$dataUrl','switch_holder','$detailUrl');
JS;
$this->registerJs($js);
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/app.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/app.css');

?>
<style>
    .switch_chart svg{
        display: block;
        margin: 0 auto;
        cursor: default;
    }
</style>

<div class="row" style="">
    <div class="col-md-12 switch_chart" id="switch_holder">
    </div>
</div>
<script type="text/single-html-template" id="switch_node_detail">
    <ul>
        <li><h4>接口信息</h4></li>
        <li><span>接口索引:</span>{ifIndex}</li>
        <li><span>接口类型描述:</span>{ifTypeDesc}</li>
        <li><span>接口描述:</span>{ifDescription}</li>
        <li><span>接口状态描述:</span>{statusDesc}</li>
        <li><span>管理状态描述:</span>{adminStatusDesc}</li>
        <li><span>操作状态描述:</span>{operationStatusDesc}</li>
        <li><span>接口速率:</span>{Ifspeed}</li>
        <li><span>ip地址:</span>{ip}</li>
        <li><span>掩码:</span>{mask}</li>
        <li><span>最后更新时间:</span>{lastChangeTime}</li>
        <li><h4>性能指标</h4></li>
        <li><span>指标名称:</span></li>
        <li><span>时间:</span></li>
        <li><span>当前值:</span></li>
    </ul>
</script>