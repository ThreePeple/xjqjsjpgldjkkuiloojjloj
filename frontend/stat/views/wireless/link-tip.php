<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-8-1.下午8:37
 * Description: 链路信息
 */
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<div class="device-info-view">

    <h4><?= Html::encode("链路信息") ?></h4>
    <?=
    GridView::widget([
        "dataProvider"=>$dataProvider,
        "pjax" => true,
        "striped" => false,
        "columns" => [
            [
                "label" => "ID",
                "value" => "id",
            ],
            [
                "label" =>"链路左接口描述",
                "value" => "leftIfDesc"
            ],
            [
                "label" =>"链路右接口描述",
                "value" => "rightIfDesc"
            ],
            [
                "label" => "状态",
                "value" =>  function($model){
                    $statusLabel = '正常';
                    switch($model->status){
                        case 1:
                            $statusLabel="正常";
                            break;
                        case 2:
                            $statusLabel="告警";
                            break;
                        default:
                    }
                    return $statusLabel;
                }
            ],
            [
                "label" => "链路带宽",
                "value" => "bandWidth"
            ],
        ],
        "export"=>false
    ]);
    ?>
</div>