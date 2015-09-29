<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/9/27
 * Time: 14:44
 */
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '告警级别黑名单';
?>
<?=
GridView::widget([
    "dataProvider"=>$dataProvider,
    //"filterModel" => $searchModel,
    //'pjax'=> true,
    "columns" => [
        'level_name',
        [
            'class' => '\kartik\grid\ActionColumn',
            'header' => '',
            'template' => '{delete}',
            'buttons'=>[
                'delete' => function($url,$model,$key){
                    $url = Url::toRoute(['/system/device-alarm/delete-bl',"id"=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                }
            ],
        ],
    ],
    'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.$this->title.'</h3>',
        'type'=>'default',
        'before' => '<form class="form-inline" method="post">'.Html::dropDownList('level','',$lists,["class"=>'form-control',
                "style"=>'width:200px;'])
            .Html::submitButton('添加',['class'=>'btn btn-primary'])
            .'</form>'
        ],
    "export"=>false
]);
?>