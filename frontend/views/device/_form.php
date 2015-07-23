<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mask')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'sysName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sysOid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'runtime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastPoll')->textInput() ?>

    <?= $form->field($model, 'categoryId')->textInput() ?>

    <?= $form->field($model, 'supportPing')->textInput() ?>

    <?= $form->field($model, 'webMgrPort')->textInput() ?>

    <?= $form->field($model, 'configPollTime')->textInput() ?>

    <?= $form->field($model, 'statePollTime')->textInput() ?>

    <?= $form->field($model, 'typeName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'positionX')->textInput() ?>

    <?= $form->field($model, 'positionY')->textInput() ?>

    <?= $form->field($model, 'symbolType')->textInput() ?>

    <?= $form->field($model, 'symbolDesc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mac')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phyName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phyCreateTime')->textInput() ?>

    <?= $form->field($model, 'series_id')->textInput() ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'interfaces')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
