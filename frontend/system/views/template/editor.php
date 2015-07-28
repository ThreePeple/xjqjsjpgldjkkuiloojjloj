<?php

$this->registerCssFile('/css/stcombobox.css' ); 
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);

?>

<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-23.上午1:17
 * Description:
 */ 
 
$js=<<<JS

	var data = {}; 

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
JS;

$this->registerJs($js);

$this->registerJsFile('/js/stcombobox.js',['depends'=>'frontend\assets\AppAsset'] ); 

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
<div class="buidling-editor-toolbar">
    <label for="switchcombo-ddi" id="addSwitchLabel">选择设备</label><span id="switchcombo"></span>
    <button type="button" class="addSwitchBtn" id="addSwitchBtn">添加设备</button>
    <button type="button" class="saveTplDataBtn" id="saveTplDataBtn">保存模版</button>
</div> 
<div class="buidling-editor-container"> 
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

$switchList = <<<abc
[
    { id: 'a1', label: '交换机1' },
    { id: 'a2', label: '交换机2' },
    { id: 'a3', label: '交换机3' },
    { id: 'a4', label: '交换机4' },
    { id: 'a5', label: '交换机5' }
]
abc;


$btnBarJS = <<<abc
!function(switchList){
$(function(){
    $('#FCEditorBtnbar .modeSwitch').click( function () {
        var mode = $(this).data('mode');
        $(this).parent().find(".modeSwitch").removeClass("active");
        $(this).addClass("active");
        ZSYFCEditor.switchMode(mode);
    } ).eq(0).trigger('click'); 
    
    // Init combo component
    var combo = new STComboBox();
    var filterList,
        selectedData_;

    combo.Init('switchcombo');
    
    function _getHasSetIdsMap(){
        var data = {};
        var lst = ZSYFCEditor.getData();
        var keys = Object.keys( lst );
        for( var i = 0, len = keys.length; i < len ; i++ ){
            data[ lst[keys[i]]["data"]["id"] ]  = 1;
        }
        return data;
    }
    
    function _buildList(){
        var data = []; 
        filterList = function(){
            var map = _getHasSetIdsMap();
            return switchList.filter( function ( itm, i ){
                if( map[itm['id']] == undefined )
                    return true;
            } );
        }(); 

        filterList.forEach( function(v, i){
            data.push({
              id: i,
              text:  filterList[i]["label"],
              data: filterList[i]
            }); 
        });
        if( data.length == 0 ){
            $('#addSwitchBtn').attr("disabled", "disabled");
        } else {
            $('#addSwitchBtn').removeAttr("disabled");
        }
        combo.populateList(data);
    }

    combo.onSelect = function(e, v, selectedData){
        selectedData_ = selectedData;
    };

    $('#addSwitchBtn').click( function() {
       if(filterList && selectedData_){
            console.log("Button: Add switch.");
            ZSYFCEditor.addShape("switch", selectedData_["data"]);
            combo.filterAndResetSelected();
            _buildList();
            selectedData_ = null;
       } 
    });
    
    $("#saveTplDataBtn").click( function () {
        // Ajax save data here.
        alert( ZSYFCEditor.getData(true) );
    } );
    
    // Refresh combo list.
    _buildList();
        
    // If remove switch node, will call updateCallback.
    ZSYFCEditor.updateCallback( function () {
        _buildList();
    }); 

});
}($switchList);
abc;

$this->registerJs($btnBarJS);

?>