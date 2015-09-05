<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessDeviceInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-device-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'deviceId') ?>

    <?= $form->field($model, 'deviceIp') ?>

    <?= $form->field($model, 'ifIndex') ?>

    <?= $form->field($model, 'ifDesc') ?>

    <?php // echo $form->field($model, 'vlanId') ?>

    <?php // echo $form->field($model, 'learnIp') ?>

    <?php // echo $form->field($model, 'learnMac') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
