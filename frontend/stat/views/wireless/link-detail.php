<?php

/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/31
 * Time: 15:02
 */
?>
<div class="device-info-view view">
    <h4>链路信息</h4>
<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    "options" => [
        "class" => 'table table-bordered detail-view'
    ],
    'attributes' => [
        [
            "label" => "左接口",
            "value" => ($model->left ? $model->left->label : ''),
        ],
        [
            "label" =>"左接口描述",
            "value" => $model->leftIfDesc
        ],
        [
            "label" => "右接口",
            "value" => ($model->right ? $model->right->label : ''),
        ],
        [
            "label" =>"链路右接口描述",
            "value" => $model->rightIfDesc
        ],
        /*[
            "label" => "接收速率",
            "value" => $model->linkspeed
        ],*/
        [
            "label" => "带宽",
            "value" => $model->bandWidth
        ],
    ],
]) ?>
</div>
<div>
    <?php
    if(!empty($alarmDatas)){
        echo '<h4>告警信息</h4>';
        echo '<table class="table table-bordered detail-view">';
        foreach($alarmDatas as $data){
            echo '<tr><th>'.$data['deviceIp'].'</th><td>'.$data['alarmDesc'].'</td></tr>';
        }
        echo '</table>';
    }
    ?>
</div>