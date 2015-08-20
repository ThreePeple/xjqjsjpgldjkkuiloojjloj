<?php
use yii\helpers\Html;  

// Init FCEditor 
$js=<<<JS
	var data = $selected;  

    // Init editor
	ZSYFCEditor.init(
        data,
        {
            svg: d3.select("svg.ZSYFCEditor"),
            width: 1521,
            height: 773
        } 
    );
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

$this->registerCssFile('/css/stcombobox.css' );
$this->registerCssFile('/css/popuppanel.css');
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);

?>
<script>

<?php
     /*
      ZSYFCEditorConfig = {
          "singleMode": true, // 编辑模式或查看模式切换。默认为编辑模式，
                              // 提供并true：查看模式（无法使用添加交换机接口）

      }
      */
?> 
var ZSYFCEditorConfig = window.ZSYFCEditorConfig = {
    "ID_KEY": "__id__",
    "shape": { 
        "router": {
            "rx": 20,
            "ry": 20,
            "imgSrc": "/images/icons3/ac.png" 
        },
        "switch": {
            "rx": 42.5,
            "ry": 32.5,
            "imgSrc": "/images/icons3/mainSwitch.png"
        },
        "server": {
            "rx": 17,
            "ry": 25,
            "imgSrc": "/images/icons3/server.png"
        },
        "firewall": {
            "rx": 19,
            "ry": 18,
            "imgSrc": "/images/icons3/firewall.png"
        }, 
        "wireless": {
            "rx": 25,
            "ry": 24,
            "imgSrc": "/images/icons3/ap.png"
        },
        "coreSwitch":{
            "rx": 26.5,
            "ry": 27.5,
            "imgSrc": "/images/icons3/core.png"
        }
    }

};  
</script> 
<style>
.content{
    overflow: auto;
}
.wireless-editor-toolbar label{
    line-height: 38px;
} 
.wireless-editor-toolbar select.device-type,
.wireless-editor-toolbar select.device-area{
    padding: 6px 5px;
}
.ZSYFCEditor-btnbar{
    width: auto !important;
    margin-top: 6px;
}
</style>
<div class="buidling-editor-toolbar wireless-editor-toolbar">
    <div class="ZSYFCEditor-btnbar" id="FCEditorModeSwitcher"> 
        <span class="btn modeSwitch dragMode" data-mode="drag" title="默认">&nbsp;</span>
        <span class="btn modeSwitch lineMode" data-mode="line" title="智能连线">&nbsp;</span>
        <span class="btn modeSwitch polylineMode" data-mode="polyline" title="折线连线">&nbsp;</span> 
    </div>
    <div style="float: right;">

        <label for="deviceType">设备类型</label>
        <select class="device-type" id="deviceType">
            <option value="switch">交换机</option> 
            <option value="server">服务器</option> 
            <option value="firewall">安全设备</option>    
            <option value="wireless">无线设备</option> 
            <option value="router">控制器</option>  
            <option value="coreSwitch">核心交换机</option>
        </select>
        <label for="switchcombo-ddi" id="addSwitchLabel">选择设备</label>
        <span id="switchcombo"></span> 
        <?=Html::button("添加设备",["class"=>"btn btn-info","id"=>"addSwitchBtn"])?>
        <?=Html::button("保存模板",["class"=>"btn btn-info","id"=>"saveTplDataBtn"])?> 
    </div>
</div> 
<div class="buidling-editor-container wireless-editor-container">
	<svg class="ZSYFCEditor" oncontextmenu="return false;" >
		<defs>
			<marker id="ZSYFCEditor_MarkerArrow" markerWidth="13" markerHeight="13" refx="9" refy="6" orient="auto">
				<path d="M2,2 L2,11 L10,6 L2,2" style="fill: #000000;" />
			</marker>
		</defs>
	</svg>
</div>

<?php
/*
$deviceList = <<<abc
{
    "router": [
        { id: 'r-a1', label: '路由器1' },
        { id: 'r-a2', label: '路由器2' },
        { id: 'r-a3', label: '路由器3' },
        { id: 'r-a4', label: '路由器4' },
        { id: 'r-a5', label: '路由器5' } 
    ],
    "switch": [
        { id: 'sw-a1', label: '交换机1' },
        { id: 'sw-a2', label: '交换机2' },
        { id: 'sw-a3', label: '交换机3' },
        { id: 'sw-a4', label: '交换机4' },
        { id: 'sw-a5', label: '交换机5' } 
    ],
    "server": [
        { id: 'se-a1', label: '服务器1' },
        { id: 'se-a2', label: '服务器2' },
        { id: 'se-a3', label: '服务器3' },
        { id: 'se-a4', label: '服务器4' },
        { id: 'se-a5', label: '服务器5' } 
    ],
    "firewall": [
        { id: 'f-a1', label: '安全设备1' },
        { id: 'f-a2', label: '安全设备2' },
        { id: 'f-a3', label: '安全设备3' },
        { id: 'f-a4', label: '安全设备4' },
        { id: 'f-a5', label: '安全设备5' } 
    ],
    "db": [
        { id: 'db-a1', label: '存储设备1' },
        { id: 'db-a2', label: '存储设备2' },
        { id: 'db-a3', label: '存储设备3' },
        { id: 'db-a4', label: '存储设备4' },
        { id: 'db-a5', label: '存储设备5' } 
    ],
    "wireless": [
        { id: 'wireless-a1', label: '无线设备1' },
        { id: 'wireless-a2', label: '无线设备2' },
        { id: 'wireless-a3', label: '无线设备3' },
        { id: 'wireless-a4', label: '无线设备4' },
        { id: 'wireless-a5', label: '无线设备5' } 
    ],
    "printer": [
        { id: 'printer-a1', label: '无线设备无限1' },
        { id: 'printer-a2', label: '无线设备2' },
        { id: 'printer-a3', label: '无线设备3' },
        { id: 'printer-a4', label: '无线设备4' },
        { id: 'printer-a5', label: '无线设备5' } 
    ],
    "pc": [
        { id: 'pc-a1', label: '服务器1' },
        { id: 'pc-a2', label: '服务器2' },
        { id: 'pc-a3', label: '服务器3' },
        { id: 'pc-a4', label: '服务器4' },
        { id: 'pc-a5', label: '服务器5' } 
    ],
    "ups": [
        { id: 'last--a1', label: '无线设备1' },
        { id: 'last--a2', label: '无线设备2' },
        { id: 'last--a3', label: '无线设备3' },
        { id: 'last--a4', label: '无线设备4' },
        { id: 'last--a5', label: '无线设备5' } 
    ]
}
abc;
*/

$deviceList = json_encode($deviceList);

$btnBarJS = <<<abc
!function(deviceList){
$(function(){
    var deviceType;
    $('#FCEditorModeSwitcher .modeSwitch').click( function () {
        var mode = $(this).data('mode');
        $(this).parent().find(".modeSwitch").removeClass("active");
        $(this).addClass("active");
        ZSYFCEditor.switchMode(mode);
    } ).eq(0).trigger('click'); 


    $('#deviceType').change( function () {
        deviceType = $(this).val();
        _buildList();
        combo.getInput().trigger('focus');
    });  

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
            if(!deviceList[deviceType])
                return [];

            var map = _getHasSetIdsMap();
            return deviceList[deviceType].filter( function ( itm, i ){
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
        combo.getInput().blur();
    };

    $('#addSwitchBtn').click( function() {
       if(filterList && selectedData_){
            //console.log("Button: Add " + deviceType + ".");
           // var area = $("#deviceArea").val();
           // selectedData_["data"]["areaId"] = area;
            ZSYFCEditor.addShape(deviceType, selectedData_["data"]);
            combo.filterAndResetSelected();
            _buildList();
            selectedData_ = null;
       } 
    });
    
    $("#saveTplDataBtn").click( function () {
        $.ajax({
            url:'/system/template/save',
            type: 'post',
            data: {
                "data": ZSYFCEditor.getData(true),
                "dataType": $type
            },
            dataType:"json",
            success:function(res){
                if(res.status){
                    alert("操作成功")
                }else{
                    alert("操作失败")
                }
            }
        });
    } );
    
    // Refresh combo list.
    deviceType = $('#deviceType').val();
    _buildList();
        
    // If remove switch node, will call updateCallback.
    ZSYFCEditor.updateCallback( function () {
        _buildList();
    }); 

    combo.getInput().bind("focus", function(e){
        selectedData_ = null;
    });

});
}($deviceList);
abc;

$this->registerJs($btnBarJS);

?>