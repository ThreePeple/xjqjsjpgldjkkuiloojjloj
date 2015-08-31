<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\helpers\Html;

?>
<script>
    function deleteBatch(){
        var keys = $("#config-list").yiiGridView("getSelectedRows");
        if(keys.length == 0) {
            alert("请选择项目");
            return false;
        }

        if(confirm("确认要删除所选项目吗？")){
            $.ajax({
                url: "/input/config-set/delete-batch",
                type: "POST",
                data: {"ids":keys},
                dataType: "json",
                success: function(res){
                    if(res.status){
                        window.location.reload()
                    }else{
                        alert("操作失败")
                    }
                }
            });
        }
    }
</script>
<div class="row" >
    <div class="col-md-12">
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
            "id" => "config-list",

            'pjax' => true,
            "columns" => [
                [
                    'label' => 'IP',
                    "value" => 'ip'
                ],
                [
                    'label' => "MAC",
                    "value" => "mac"
                ],
                [
                    "label" => "状态",
                    "value" => "status"
                ],
                [
                    "class" => '\kartik\grid\ActionColumn',
                    'header' => '',
                    'template' => '{delete}',
                    'width' => '40px'
                ],
                [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                ]
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 下发配置管理</h3>',
                'type'=>'default',
                'before'=> '<form class="form-inline" action="/input/config-set/send">
  <div class="form-group">
    <label for="IP">IP:</label>
    <input type="text" class="form-control" id="IP" name="ip" placeholder="ip地址">
  </div>
  <div class="form-group">
    <label for="mac">MAC:</label>
    <input type="text" class="form-control" id="mac" name="mac" placeholder="">
  </div>
  <button type="submit" class="btn btn-default">下发配置</button>
</form>',
            ],
            /*
            'toolbar' => [
                [
                    "content" => Html::button('<i class="glyphicon glyphicon-download-alt"></i> 删除选择项',[
                        'onclick' => 'deleteBatch()',
                        'class' => "btn btn-primary"
                    ])
                ],
                '{export}',
                '{toggleData}'
            ],*/
            "export" => [
                'label' => "导出数据",
                'showConfirmAlert'=>false,
                'target' => GridView::TARGET_SELF
            ],
            "exportConfig" => [
                GridView::EXCEL => [
                    'label' => 'Excel',
                    'icon' => 'floppy-open',
                    'iconOptions' => ['class' => 'text-success'],
                    'showHeader' => true,
                    'showPageSummary' => true,
                    'showFooter' => true,
                    'showCaption' => true,
                    'filename' => 'jumper',
                    'alertMsg' => 'The EXCEL export file will be generated for download.',
                    'options' => ['title' =>  'Microsoft Excel 95+'],
                    'mime' => 'application/vnd.ms-excel',
                    'config' => [
                        'worksheet' => 'jumper',
                        'cssFile' => ''
                    ]
                ]
            ]
        ]);
        ?>
    </div>
</div>
