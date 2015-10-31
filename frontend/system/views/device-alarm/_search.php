<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\DeviceAlarmSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-inline .form-group{
        vertical-align: inherit;
        margin-right: 15px;
    }
    .form-inline .form-group label.control-label:after{
        content: ":";
        display: inline-block;
        margin: 0 2px;
    }
</style>
<div class="device-alarm-search">

    <?php $form = ActiveForm::begin([
        'action' => [$action],
        'method' => 'get',
        'options' =>[
            'class' => 'form-inline'
        ]
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

    <?php  echo $form->field($model, 'recStatus',['options'=>['class'=>'form-group']])->widget
    (Select2::className(),[
        "data" => [
            '0' => '未恢复',
            '1' => '已恢复',
        ],
        'hideSearch' => true,
        'options' => ['placeholder' => '选择状态'],
        'pluginOptions' => [
            'allowClear' => true,
            'width' => '150'
        ]]) ?>

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
        <?= Html::submitButton('查询', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
