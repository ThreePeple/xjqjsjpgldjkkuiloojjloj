<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class'=>"form-inline"]
    ]); ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'port') ?>

    <?= $form->field($model, 'wire_frame') ?>

    <?= $form->field($model, 'wire_position') ?>

    <?= $form->field($model, 'point') ?>

    <?= $form->field($model, 'tag') ?>

    <div class="">
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('重置', ['class' => 'btn btn-default clear-form']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
