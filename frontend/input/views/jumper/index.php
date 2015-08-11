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
				'onUploadComplete' : function(file, data) {
				    console.log(data);
				}
			});
JS;
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
                "insert_no"
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 用户列表</h3>',
                'type'=>'default',
                'before'=>Html::input("file","upload-file",'',['id'=>"upload-file",'class'=>"btn btn-primary"]),
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>
