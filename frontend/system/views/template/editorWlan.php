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
            width: 1366,
            height: 768
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
        "switch": {
            "rx": 24.5,
            "ry": 15,
            "imgSrc": "/images/icons/switch2.png"
        },
        "server": {
            "rx": 17,
            "ry": 25,
            "imgSrc": "/images/icons/server.png"
        },
        "firewall": {
            "rx": 19,
            "ry": 18,
            "imgSrc": "/images/icons/firewall.png"
        }
    }

};  
</script> 
<style>
    .content{
        overflow: auto;
    }
    .wlan-editor-toolbar label{
        line-height: 38px;
    } 
    .wlan-editor-toolbar select.device-type{
        padding: 6px 5px;
    }
    .ZSYFCEditor-btnbar{
        width: auto !important;
        margin-top: 6px;
    }
</style>
<div class="buidling-editor-toolbar wlan-editor-toolbar">
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
            <option value="firewall">防火墙</option> 
        </select>
        <label for="switchcombo-ddi" id="addSwitchLabel">选择设备</label>
        <span id="switchcombo"></span> 
        <?=Html::button("添加设备",["class"=>"btn btn-info","id"=>"addSwitchBtn"])?>
        <?=Html::button("保存模板",["class"=>"btn btn-info","id"=>"saveTplDataBtn"])?> 
    </div>
</div> 
<div class="buidling-editor-container wlan-editor-container">  
	<svg class="ZSYFCEditor" oncontextmenu="return false;" >
		<defs>
			<marker id="ZSYFCEditor_MarkerArrow" markerWidth="13" markerHeight="13" refx="9" refy="6" orient="auto">
				<path d="M2,2 L2,11 L10,6 L2,2" style="fill: #000000;" />
			</marker>
		</defs>
	</svg>
</div> 

<?php
 
$deviceList = <<<abc
{
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
        { id: 'f-a1', label: '防火墙1' },
        { id: 'f-a2', label: '防火墙2' },
        { id: 'f-a3', label: '防火墙3' },
        { id: 'f-a4', label: '防火墙4' },
        { id: 'f-a5', label: '防火墙5' } 
    ]
}
abc;


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
            console.log("Button: Add " + deviceType + ".");
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
                    alert("操作作失败")
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