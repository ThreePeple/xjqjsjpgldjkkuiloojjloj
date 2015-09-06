<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessDeviceInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-device-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deviceId')->textInput() ?>

    <?= $form->field($model, 'deviceIp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ifIndex')->textInput() ?>

    <?= $form->field($model, 'ifDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vlanId')->textInput() ?>

    <?= $form->field($model, 'learnIp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'learnMac')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
