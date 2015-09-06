<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\helpers\Html;

$uploadUrl = \yii\helpers\Url::toRoute(['/input/jumper/import']);


$this->registerJsFile('/js/uploadifive/jquery.uploadifive.min.js',["depends"=> 'frontend\assets\AppAsset']);
$this->registerCssFile('/js/uploadifive/uploadifive.css');

$js=<<<JS
$('#upload-file').uploadifive({
				'auto'             : true,
				'uploadScript'     : '$uploadUrl',
				"buttonClass" : 'btn btn-primary',
				'buttonText': '导入数据',
				'height' : '34',
				'onUploadComplete' : function(file, data) {
                    if(data==1){
                        window.location.reload()
                    }else{
                        alert("文件导入失败！")
                    }
				}
			});
JS;
$css = <<<CSS
 #uploadifive-upload-file.btn{
    padding:0;
}
CSS;
$this->registerCss($css);
$this->registerJs($js);
?>
<script>
    function deleteBatch(){
        var keys = $("#jumper-list").yiiGridView("getSelectedRows");
        if(keys.length == 0) {
            alert("请选择项目");
            return false;
        }

        if(confirm("确认要删除所选项目吗？")){
            $.ajax({
                url: "/input/jumper/delete-batch",
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
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">筛选</h3>
            </div>
            <div class="panel-body">
                <?=$this->render("_search",["model"=>$model]);?>
            </div>
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-md-12">
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
           //∂ 'filterModel' => $model,
            "id" => "jumper-list",

            //'pjax' => true,
            "columns" => [
                [
                    'class'=>'kartik\grid\EditableColumn',
                    'attribute' => "ip",
                    "editableOptions"=>[
                        "pluginEvents" => [
                            "editableSuccess" => "function(event,val,form,data){window.location.reload();}"
                        ]
                    ]
                ],
                [
                    'class'=>'kartik\grid\EditableColumn',
                    'attribute' => 'port',
                ],
                [
                    'class'=>'kartik\grid\EditableColumn',
                    'attribute' => "wire_frame",
                ],
                [
                    'class'=>'kartik\grid\EditableColumn',
                    'attribute' => 'wire_position',
                ],
                [
                    'class'=>'kartik\grid\EditableColumn',
                    'attribute' => 'point',
                ],
                [
                    "attribute"=>"insert_no",
                    "hidden" => true,
                ],
                [
                    'class'=>'kartik\grid\EditableColumn',
                    'attribute' => 'tag',
                    'editableOptions' => [
                        "inputType" => \kartik\editable\Editable::INPUT_HIDDEN,
                        //"beforeInput" => Html::label('点位标签'),
                        //"inputContainerOptions" => ["disabled"=>"disabled"],
                        "afterInput" => function($form,$widget){
                            echo $form->field($widget->model,'insert_no');
                        },
                        "pluginEvents" => [
                            "editableSuccess" => "function(event,val,form,data){window.location.reload();}"
                        ]
                    ],
                    'headerOptions' => [
                        'class' => 'skip-export'
                    ],
                    "contentOptions" => [
                        "class" => 'skip-export'
                    ]
                ],
                [
                    'label' => '',
                    "value" => function($model){
                        return Html::a('删除',\yii\helpers\Url::toRoute(['/input/jumper/delete',"id"=>$model->id]),['class'=>'btn btn-link']);
                    },
                    "format" => "raw",
                    'headerOptions' => [
                        'class' => 'skip-export'
                    ],
                    "contentOptions" => [
                        "class" => 'skip-export'
                    ]
                ],
                [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                ]
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 跳线管理</h3>',
                'type'=>'default',
                'before'=>Html::input("file","upload-file",'',['id'=>"upload-file",'class'=>"btn btn-primary"]),
            ],
            'toolbar' => [
                [
                    "content" => Html::button('<i class="glyphicon glyphicon-download-alt"></i> 删除选择项',[
                        'onclick' => 'deleteBatch()',
                        'class' => "btn btn-primary"
                    ])
                ],
                '{export}',
                '{toggleData}'
            ],
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
            ],
        ]);
        ?>
    </div>
</div>
