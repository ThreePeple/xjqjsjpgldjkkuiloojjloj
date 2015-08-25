<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceAlarm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-alarm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'OID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'originalTypeDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceId')->textInput() ?>

    <?= $form->field($model, 'deviceIp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alarmLevel')->textInput() ?>

    <?= $form->field($model, 'alarmLevelDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alarmCategory')->textInput() ?>

    <?= $form->field($model, 'alarmCategoryDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'faultTime')->textInput() ?>

    <?= $form->field($model, 'faultTimeDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recTime')->textInput() ?>

    <?= $form->field($model, 'recTimeDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recStatus')->textInput() ?>

    <?= $form->field($model, 'recStatusDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recUserName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ackTime')->textInput() ?>

    <?= $form->field($model, 'ackTimeDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ackStatus')->textInput() ?>

    <?= $form->field($model, 'ackStatusDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ackUserName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alarmDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'somState')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eventName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'defineType')->textInput() ?>

    <?= $form->field($model, 'customAlarmLevel')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'specificId')->textInput() ?>

    <?= $form->field($model, 'originalType')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
