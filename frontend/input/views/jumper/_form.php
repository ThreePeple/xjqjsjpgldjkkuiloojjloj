<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JumperInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jumper-info-form">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        "type" => ActiveForm::TYPE_HORIZONTAL,
        'enableClientScript'=> true,
    ]); ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'port')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wire_frame')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wire_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'point')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-info']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
