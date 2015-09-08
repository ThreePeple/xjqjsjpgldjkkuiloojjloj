<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/9/7
 * Time: 22:10
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>
            修改密码</h3></div>
<div class="panel-body">
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'user-form',
            'enableClientScript'=> true,
        ]);
    ?>

        <div class="col-md-8">

            <?= $form->field($model, "password_set")->passwordInput(); ?>
            <?= $form->field($model, "password_confirm")->passwordInput() ?>
            <?= Html::submitButton('保存', ['class' => 'btn btn-info']) ?>
        </div>

    <div class="form-group">
        <div class="">

        </div>
    </div>
    <?php $form->end()?>
</div>
<div class="panel-footer"></div>
</div>
