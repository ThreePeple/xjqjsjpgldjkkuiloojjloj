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
				    window.location.reload()
				}
			});
JS;
$css = <<<CSS
 .btn{
    padding:0;
}
CSS;
$this->registerCss($css);
$this->registerJs($js);
?>

<div class="row" >
    <div class="col-md-12">
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
            "columns" => [
                'ip',
                "port",
                "wire_frame",
                "wire_position",
                "point",
                "insert_no",
                [
                    'label' => '',
                    "value" => function($model){
                        return Html::a('删除',\yii\helpers\Url::toRoute(['/input/jumper/delete',"id"=>$model->id]),['class'=>'btn btn-link']);
                    },
                    "format" => "raw"
                ]
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 跳线管理</h3>',
                'type'=>'default',
                'before'=>Html::input("file","upload-file",'',['id'=>"upload-file",'class'=>"btn btn-primary"]),
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>
