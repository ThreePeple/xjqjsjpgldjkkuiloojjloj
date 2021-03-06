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
                "username",
                [
                    'label' => Html::a('角色','javascript:void(0)'),
                    'value' => 'roleShow',
                    'encodeLabel'=> false,
                ],
                "name",
                "phone",
                "email",
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'width' => '120px',
                    'header' => '',
                    'template' => '{reset} {update}  {delete}',
                    'buttons' =>[
                        'reset' => function($url,$model,$key){
                            return Html::a('<span class="glyphicon glyphicon-lock"></span>',
                                \yii\helpers\Url::toRoute(['/system/user/reset-password', 'id'=>$model->id]),
                                ["title"=>'重置密码']
                                );
                        },
                        'delete' => function($url,$model,$key){
                            return ($model->id==1 || $model->id == Yii::$app->user->identity->getId())? '' : Html::a
                            ('<span
                            class="glyphicon
                            glyphicon-trash"></span>',
                                \yii\helpers\Url::toRoute(['/system/user/delete', 'id'=>$model->id]),
                                ["title"=>'删除']
                            );
                        }
                    ]
                ],
            ],
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> 用户列表</h3>',
                'type'=>'default',
                'before'=>Yii::$app->user->can('admin') ? Html::a('<i class="glyphicon glyphicon-plus"></i> 创建用户',
                ['create'],
                        ['class' =>
                        'btn
                btn-primary']) : '',
            ],
            "export"=>false,
        ]);
        ?>
    </div>
</div>
