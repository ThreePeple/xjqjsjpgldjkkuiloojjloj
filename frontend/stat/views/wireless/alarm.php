<?php
/**
 * 设备告警页面
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-29.下午7:30
 * Description:
 */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
?>

<div class="device-info-view">

    <h1><?= Html::encode("设备告警信息") ?></h1>
        <?=
        GridView::widget([
            "dataProvider"=>$dataProvider,
            'pjax' => true,
            "columns" => [
                "id",
                "alarmLevelDesc",
                "alarmCategoryDesc",
                "faultTimeDesc",
                "recTimeDesc",
                "alarmDesc"
            ],
            "export"=>false
        ]);
        ?>
</div>