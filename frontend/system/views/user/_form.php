<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-15.下午2:13
 * Description:
 */


use kartik\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>
            <?=$this->title?></h3></div>
    <div class="panel-body">
        <?php
        $form = ActiveForm::begin(
            [
                'id' => 'user-form',
                "type" => ActiveForm::TYPE_HORIZONTAL,
                'enableClientScript'=> true,
            ]);
        ?>
        <?php
            if($model->isNewRecord) {
                ?>
                <div class="col-md-8">
                    <div class="page-header">
                        <h3>登录信息
                            <small></small>
                        </h3>
                    </div>
                    <?= $form->field($model, "username", [
                        'feedbackIcon' => [
                            'prefix' => 'fa fa-',
                            'default' => 'user',
                            'success' => 'check-circle',
                            'error' => 'exclamation-circle',
                        ],
                        'enableAjaxValidation' => true,
                        'inputOptions' => [
                            'disabled' => $model->isNewRecord ? false : ''
                        ]
                    ]) ?>
                    <?= $form->field($model, "password_set", [
                        'feedbackIcon' => [
                            'prefix' => 'fa fa-',
                            'default' => 'lock',
                            'success' => 'check-circle',
                            'error' => 'exclamation-circle',
                        ]])->passwordInput(); ?>
                    <?= $form->field($model, "password_confirm", [
                        'feedbackIcon' => [
                            'prefix' => 'fa fa-',
                            'success' => 'check-circle',
                            'error' => 'exclamation-circle',
                        ]])->passwordInput() ?>
                </div>
            <?php
            }
        ?>
        <div class="col-md-8">
            <div class="page-header">
                <h3>基础信息<small></small></h3>
            </div>
            <?= $form->field($model, "role")->dropDownList(['admin'=>'管理员','operator'=>'普通用户'])?>

            <?=$form->field($model,"name", [
                'feedbackIcon' => [
                    'prefix' => 'fa fa-',
                    'default' => 'pencil',
                    'success' => 'check-circle',
                    'error' => 'exclamation-circle',
                ]])?>
            <?=$form->field($model, 'phone', [
                'feedbackIcon' => [
                    'prefix' => 'fa fa-',
                    'default' => 'mobile',
                    'success' => 'check-circle',
                    'error' => 'exclamation-circle',
                ]])->widget('yii\widgets\MaskedInput', [
                'mask' => '199-9999-9999'
            ])?>
            <?=$form->field($model,"email",[
                'feedbackIcon' => [
                    'prefix' => 'fa fa-',
                    'default' => 'at',
                    'success' => 'check-circle',
                    'error' => 'exclamation-circle',
                ]])?>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('保存', ['class' => 'btn btn-info']) ?>
            </div>
        </div>
        <?php $form->end()?>
    </div>
    <div class="panel-footer"></div>
</div>
