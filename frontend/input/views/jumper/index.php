<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\helpers\Html;

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
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 导入数据', ['import'], ['class' => 'btn btn-info']),
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>
