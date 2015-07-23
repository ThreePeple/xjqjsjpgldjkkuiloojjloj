<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-23.上午1:17
 * Description:
 */
$js=<<<JS
var data = {
        "1": {
            "attributes":{
                "type": "circle",
                "title": "abc",
                "cx": 100,
                "cy": 100,
                "r": 20
            },
            "links":[ "2" ]
        },
        "2": {
            "attributes": {
                "type": "ellipse",
                "title": "",
                "cx": 160,
                "cy": 180,
                "rx": 20,
                "ry": 30
            }
        },
        "3": {
            "attributes": {
                "type": "ellipse",
                "title": "",
                "cx": 260,
                "cy": 280,
                "rx": 20,
                "ry": 30
            }
        }
    };
    var data = {};
    //try{
    ZSYFCEditor.init(
        data,
        {
            svg: d3.select("svg.ZSYFCEditor"),
            width: 1000,
            height: 800
        } );
JS;

$this->registerJs($js);

$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/FCShapeMaker.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCEditor.js',['depends'=>'frontend\assets\AppAsset']);

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/style.css');
?>
<div style="width: 1000px;height:850px; margin: 0; padding: 0;">
<div class="ZSYFCEditor-btnbar">
    <span class="btn mainSwitch" onclick="ZSYFCEditor.addShape('mainSwitch')" title="聚汇交换机"><img src="/images/icons/switch1.png" height="25" ></span>
    <span class="btn switch" onclick="ZSYFCEditor.addShape('switch')" title="交换机"><img src="/images/icons/switch2.png" height="25" ></span>
    <span class="btn server" onclick="ZSYFCEditor.addShape('server')" title="服务器"><img src="/images/icons/server.png" height="25" ></span>
    <span class="btn db" onclick="ZSYFCEditor.addShape('db')" title="数据库服务器"><img src="/images/icons/db.png" height="25" ></span>
    <span class="btn firewall" onclick="ZSYFCEditor.addShape('firewall')" title="防火墙"><img src="/images/icons/firewall.png" height="25" ></span>
</div>
<svg class="ZSYFCEditor" oncontextmenu="return false;" >
    <defs>
        <marker id="ZSYFCEditor_MarkerArrow" markerWidth="13" markerHeight="13" refx="9" refy="6" orient="auto">
            <path d="M2,2 L2,11 L10,6 L2,2" style="fill: #000000;" />
        </marker>
    </defs>
    <g class="container"></g>
</svg>
</div>
<script>

</script>