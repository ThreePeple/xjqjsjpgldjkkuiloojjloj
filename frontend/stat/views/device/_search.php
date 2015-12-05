<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline'
        ]
    ]); ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'label') ?>

    <?= $form->field($model, 'typeName') ?>

    <?= $form->field($model, 'series') ?>

    <?php  echo $form->field($model, 'model') ?>

    <?php  echo $form->field($model, 'mask') ?>

    <?php  echo $form->field($model, 'mac') ?>

    <?= $form->field($model, 'status',['options'=>['class'=>'form-group']])->widget
    (Select2::className(),[
        "data" => [
            '-1' =>'未管理',
            '0' => '未知',
            '1' => '正常',
            '2' => '警告',
            '3' => '次要',
            '4' => '重要',
            '5' => '严重',
        ],
        'options' => ['placeholder' => '选择状态'],
        'pluginOptions' => [
            'allowClear' => true,
            'width' => '200'
        ]]) ?>

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
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('重置', ['class' => 'btn btn-default clear-form']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
