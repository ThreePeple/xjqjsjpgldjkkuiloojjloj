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
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'label') ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'mask') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sysName') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'sysOid') ?>

    <?php // echo $form->field($model, 'runtime') ?>

    <?php // echo $form->field($model, 'lastPoll') ?>

    <?php // echo $form->field($model, 'categoryId') ?>

    <?php // echo $form->field($model, 'supportPing') ?>

    <?php // echo $form->field($model, 'webMgrPort') ?>

    <?php // echo $form->field($model, 'configPollTime') ?>

    <?php // echo $form->field($model, 'statePollTime') ?>

    <?php // echo $form->field($model, 'typeName') ?>

    <?php // echo $form->field($model, 'positionX') ?>

    <?php // echo $form->field($model, 'positionY') ?>

    <?php // echo $form->field($model, 'symbolType') ?>

    <?php // echo $form->field($model, 'symbolDesc') ?>

    <?php // echo $form->field($model, 'mac') ?>

    <?php // echo $form->field($model, 'phyName') ?>

    <?php // echo $form->field($model, 'phyCreateTime') ?>

    <?php // echo $form->field($model, 'series_id') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'interfaces') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Reset', ['class' => 'btn btn-default clear-form']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
