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
    // Prev server-saved-data.
	var data = {}; 
 
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
 
    //try{ 
	ZSYFCEditor.init(
        data,
        {
            svg: d3.select("svg.ZSYFCEditor"),
            width: 900,
            height: 560
        } );
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
</script>
<div style="width: 900px;height:620px; margin: 0; padding: 0;">
	<div class="ZSYFCEditor-btnbar" id="FCEditorBtnbar">
		<span class="btn modeSwitch dragMode" data-mode="drag" title="默认">&nbsp;</span>
        <span class="btn modeSwitch lineMode" data-mode="line" title="智能连线">&nbsp;</span>
        <span class="btn modeSwitch polylineMode" data-mode="polyline" title="折线连线">&nbsp;</span>

	</div>
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