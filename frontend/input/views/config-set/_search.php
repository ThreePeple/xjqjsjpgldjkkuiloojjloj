<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessDeviceInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-inline .form-group{
        vertical-align: inherit;
    }
</style>
<div class="access-device-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            "class" => 'form-inline'
        ]
    ]); ?>



    <?= $form->field($model, 'deviceIp') ?>

    <?php  echo $form->field($model, 'learnIp') ?>


    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('重置', ['class' => 'btn btn-default clear-form']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
