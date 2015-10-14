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
            width: 1280,
            height: 940
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
            "rx": 15,
            "ry": 7.5,
            "imgSrc": "/images/building_switch_status2/s-1.gif"
        } 
    }

}; 

</script> 
<style>
    .buidling-editor-container {
        overflow: hidden;
    }
    svg.ZSYFCEditor {
        left: auto !important;
        top: auto !important;
        right: 0 !important;
        bottom: 0 !important;
    }
    section.content{
        overflow: auto;
    }
</style>
<div class="buidling-editor-toolbar">
    <label for="switchcombo-ddi" id="addSwitchLabel">选择设备</label><span id="switchcombo"></span> 
    <?=Html::button("添加设备",["class"=>"btn btn-info","id"=>"addSwitchBtn"])?>
    <?=Html::button("保存模板",["class"=>"btn btn-info","id"=>"saveTplDataBtn"])?> 
    <?=Html::button("重置模版",["class"=>"btn btn-info","id"=>"resetTplDataBtn"])?> 
</div> 
<div class="buidling-editor-container">  
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
$switchList = <<<abc
[
    { id: 'a1', label: '交换机1' },
    { id: 'a2', label: '交换机2' },
    { id: 'a3', label: '交换机3' },
    { id: 'a4', label: '交换机4' },
    { id: 'a5', label: '交换机5' }
]
abc;
*/
$switchList = json_encode($lists);

$btnBarJS = <<<abc
!function(switchList){
$(function(){    
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
        combo.getInput().blur();
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

    $("#resetTplDataBtn").click( function () {
        ZSYFCEditor.reset(true);
    } );

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
    _buildList();
        
    // If remove switch node, will call updateCallback.
    ZSYFCEditor.updateCallback( function () {
        _buildList();
    }); 

    combo.getInput().bind("focus", function(e){
        selectedData_ = null;
    });

});
}($switchList);
abc;

$this->registerJs($btnBarJS);

?>