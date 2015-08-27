<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/8/27
 * Time: 01:30
 */

use yii\helpers\Html;

?>
<div class="device-info-view view">

    <h4><?= Html::encode("设备详细信息") ?></h4>
<?php
/*
    <!--<p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>-->
*/
?>
<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    "options" => [
        "class" => "table table-bordered detail-view"
    ],
    'attributes' => [
        'id',
        'label',
        'ipAddress',
        'macAddress',
        'location',
        'onlineClientCount',
    ],
]) ?>

</div>