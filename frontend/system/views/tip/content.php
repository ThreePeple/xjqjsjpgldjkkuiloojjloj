<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/19
 * Time: 11:51
 */

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<div style="margin: 0;padding: 0">
        <?=GridView::widget([
            "dataProvider" => $dataProvider,
            "id" => "info_config_".$type,
            'tableOptions' => [
                "class" => 'table table-striped table-bordered',
                "style" => "margin-left:10px;width:90%"
            ],
            "columns" => [
                [
                    'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    "checkboxOptions" => function($model,$key,$index,$column){
                        return ["checked"=>($model->is_show?"checked":'')];
                    }
                ],
                [
                    "label" => "字段名",
                    "attribute" => 'key'
                ]
            ],
            "showFooter" => false,
            "layout" => "{items}",
            "export" => false,
        ])?>
        <?=Html::button("保存设置",["class"=>"btn btn-primary save","type"=>$type])?>
</div>