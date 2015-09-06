<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceAlarmSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-alarm-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'deviceIp') ?>

    <?= $form->field($model, 'deviceName') ?>

    <?= $form->field($model, 'alarmLevelDesc') ?>


    <?php // echo $form->field($model, 'deviceName') ?>

    <?php // echo $form->field($model, 'alarmLevel') ?>

    <?php // echo $form->field($model, 'alarmLevelDesc') ?>

    <?php // echo $form->field($model, 'alarmCategory') ?>

    <?php // echo $form->field($model, 'alarmCategoryDesc') ?>

    <?php // echo $form->field($model, 'faultTime') ?>

    <?php // echo $form->field($model, 'faultTimeDesc') ?>

    <?php // echo $form->field($model, 'recTime') ?>

    <?php // echo $form->field($model, 'recTimeDesc') ?>

    <?php // echo $form->field($model, 'recStatus') ?>

    <?php // echo $form->field($model, 'recStatusDesc') ?>

    <?php // echo $form->field($model, 'recUserName') ?>

    <?php // echo $form->field($model, 'ackTime') ?>

    <?php // echo $form->field($model, 'ackTimeDesc') ?>

    <?php // echo $form->field($model, 'ackStatus') ?>

    <?php // echo $form->field($model, 'ackStatusDesc') ?>

    <?php // echo $form->field($model, 'ackUserName') ?>

    <?php // echo $form->field($model, 'alarmDesc') ?>

    <?php // echo $form->field($model, 'somState') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'eventName') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'defineType') ?>

    <?php // echo $form->field($model, 'customAlarmLevel') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'specificId') ?>

    <?php // echo $form->field($model, 'originalType') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
