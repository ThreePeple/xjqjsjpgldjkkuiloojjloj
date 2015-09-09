<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SmsTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sms-template-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?=$this->title?></div>
        <div class="panel-body">
            <?=$form->field($model,'name')?>
            <?=$form->field($model,"content")->textarea(['rows' => 6])?>
            <div class="form-group">
                *动态内容替换成宏变量，支持的变量：<br>
                <?php
                    $micros = $model->getMacroVariables();
                    foreach($micros as $k=>$label){
                        echo $label.':  '.$k.'<br>';
                    }
                ?>
                示例： 工作提醒：设备__DEVICE_IP__发生告警，告警类型为__ALARM_CATEGORY__,告警级别 :__ALARM_LEVEL__,请尽快处理！
            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
