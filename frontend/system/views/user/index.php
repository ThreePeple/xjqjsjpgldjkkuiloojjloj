<?php
/* @var $this yii\web\View */
//use frontend\widgets\DataTableAsset;
//use frontend\widgets\DataTable;
use kartik\grid\GridView;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">筛选</h3>
            </div>
            <div class="panel-body">
                <?=$this->render("_search",["model"=>$searchModel]);?>
            </div>
        </div>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
            "columns" => [
                'id',
                "username",
                "name",
                "phone",
                "email",
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'width' => '80px',
                    'header' => '',
                    'template' => '{update}  {delete}',
                ],
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 用户列表</h3>',
                'type'=>'default',
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> 创建用户', ['create'], ['class' => 'btn btn-primary']),
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>
