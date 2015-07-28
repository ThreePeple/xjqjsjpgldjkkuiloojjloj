<?php

use kartik\widgets\Select2;
use yii\web\JsExpression;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-23.上午1:17
 * Description:
 */ 
 
$js=<<<JS

	var data = $selected;

 /* // demo data.
    var data = {
            "2":{
                "attributes":{"type":"switch","title":"aaa","cx":266,"cy":274,"rx":25,"ry":15,"__id__":"2"},
                "data":{"id":2,"label":"aaa"},
                "links": [
                    {
                        "type": "polyline",
                        "data": {
                            "from": "2",
                            "to": "3",
                            "linkPoints": [
                                [ "222", "120" ],
                                [ "120", "222" ]
                            ]
                        }
                    }
                ]
            },
            "3":{
                "attributes":{"type":"switch","title":"bbb","cx":450,"cy":280,"rx":25,"ry":15,"__id__":"3"},
                "data":{"id":2,"label":"bbb"},
                "links": [
                    {
                        "type": "line",
                        "data": {
                            "from": "3",
                            "to": "4"
                        }
                    }
                ]
            },
            "4":{
                "attributes":{"type":"switch","title":"DDDD","cx":500,"cy":380,"rx":25,"ry":15,"__id__":"4"},
                "data":{"id":2,"label":"DDDD"}
            }
    }; 
 */
    //try{ 
	ZSYFCEditor.init(
        data,
        {
            svg: d3.select("svg.ZSYFCEditor"),
            width: 1011,
            height: 676
        } );

     $("#addDevice").click(function(){
        removeOption();
     })
     $("#saveTemplate").click(function(){
        var data = {};
        data["type"] = $("#dataType").val();
        data["data"] = ZSYFCEditor.getData();
        $.ajax({
            url:'/system/template/save',
            type: 'post',
            data: data,
            dataType:"json",
            success:function(res){
                if(res.status){
                    alert("操作成功")
                }else{
                    alert("操作作失败")
                }
            }
        })
     })
JS;

$this->registerJs($js);

$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);

$this->registerJsFile('/js/ZSYFCEditorUtil.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCNodeData.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCShapeMaker.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCObjectCollector.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/ZSYFCLinePathPosition.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCHelperPosition.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCLinkline.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/ZSYFCEditor.js',['depends'=>'frontend\assets\AppAsset']);

$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);

?>
<script>
var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
    "ID_KEY": "__id__",
    "shape": {
        "circle": {
            "r": 20
        },
        "ellipse": {
            "rx": 30,
            "ry": 20,
        },
        "mainSwitch": {
            "rx": 39,
            "ry": 18,
            "imgSrc": "/images/icons/switch1.png"
        },
        "switch": {
            "rx": 25,
            "ry": 15,
            "imgSrc": "/images/icons/switch2.png"
        },
        "server": {
            "rx": 17,
            "ry": 25,
            "imgSrc": "/images/icons/server.png"
        },
        "db": {
            "rx": 19,
            "ry": 13,
            "imgSrc": "/images/icons/db.png"
        },
        "firewall": {
            "rx": 19,
            "ry": 18,
            "imgSrc": "/images/icons/firewall.png"
        }
    }

};
function removeOption() {
    if($("#select-device").val()== '') {
        alert("请先选择设备");
        return false;
    }
    var current = $("#select-device option:selected");
    ZSYFCEditor.addShape('switch',{id:current.attr('value'),label:current.text()})
    $("#select-device").find("option")
        // .filter(function(){ return this.value === e.params.data.id; }).prop({disabled:true}).end()
        .filter(":selected").remove().end()
        .end()
        .select2({theme:"krajee",placeholder: "请选择设备",allowClear:true});
    /*
     * s2.find("option")
     .filter(function(){ return this.value === e.params.data.id; }).prop({disabled:true}).end()
     .filter(":enabled:first").prop({selected:true}).end()
     .end()
     .select2("refresh");
     * */
}
function addOption(obj){
    $("#select-device")
        .append('<option value="'+obj.id+'">'+obj.text+'</option>').end()
        .select2({theme:'krajee',placeholder: "请选择设备",allowClear:true});
}

</script>
    <div class="row">
        <?=Html::hiddenInput("dataType",$type,["id"=>"dataType"])?>
        <div class="col-md-6">
            <?=Select2::widget([
                'name' => 'select-device',
                "id" => "select-device",
                'data' => $lists,
                'options' => ['placeholder' => '请选择添加设备'],

                'pluginOptions' => [
                    'allowClear' => true,
                    /*
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => '/system/template/ajax-items',
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],

                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) {console.log(city); return city.text; }'),
                    */
                ],

                /*
                "pluginEvents" => [
                    //  "change" => "function() { console.log('change'); }",
                    //  "select2:open" => "function(e) { console.log($(e.target).find('option')[0].attr('disabled')); }",
                    // "select2:closing" => "function() { console.log('close'); }",
                    // "select2:close" => "function() { console.log('close'); }",
                    //  "select2:selecting" => "function() { console.log('selecting'); }",
                    "select2:select" => "function(e) { console.log('selected'); }",
                    //  "select2:unselecting" => "function() { console.log('unselecting'); }",
                    "select2:unselect" => "function() { console.log('unselect'); }"
                ]
                */
            ]);?>
        </div>
        <?=Html::button("添加设备",["class"=>"btn btn-info","id"=>"addDevice"])?>
        <?=Html::button("保存模板",["class"=>"btn btn-info","id"=>"saveTemplate"])?>
    </div>
<div style="margin: 0; padding: 0; background-color: #353535; border: 1px solid #a0a0a0;width: 1011px; height: 676px; box-sizing:border-box">

<?php 
/*
	<div class="ZSYFCEditor-btnbar" id="FCEditorBtnbar">
		<span class="btn modeSwitch dragMode" data-mode="drag" title="默认">&nbsp;</span>
        <span class="btn modeSwitch lineMode" data-mode="line" title="智能连线">&nbsp;</span>
        <span class="btn modeSwitch polylineMode" data-mode="polyline" title="折线连线">&nbsp;</span>

	</div>
*/ 
?>
	<svg class="ZSYFCEditor" oncontextmenu="return false;" >
		<defs>
			<marker id="ZSYFCEditor_MarkerArrow" markerWidth="13" markerHeight="13" refx="9" refy="6" orient="auto">
				<path d="M2,2 L2,11 L10,6 L2,2" style="fill: #000000;" />
			</marker>
		</defs>
		<g class="svg-container"></g>
	</svg>
</div> 

<?php
$btnbar = <<<abc

$(function(){
    $('#FCEditorBtnbar .modeSwitch').click( function () {
        var mode = $(this).data('mode');
        $(this).parent().find(".modeSwitch").removeClass("active");
        $(this).addClass("active");
        ZSYFCEditor.switchMode(mode);
    } ).eq(0).trigger('click');
});
abc;

$this->registerJs($btnbar);

?>