<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-lock form-control-feedback'></span>"
];
?>
<style>
.login-page {
	background-color:#252525;
}
.login-box-body{
	border-radius: 10px; 
    box-shadow: 0 0 15px 0 #fff; 
}
.login-logo, .register-logo {
    margin-bottom: -8px;
}
.login-logo{ 
	color: #fff;
	height: 108px;
}
.login-logo .logo{
	margin: 0 6px 0 6px;
	float: left;
}
.login-logo  i{
	margin-top: 10px;
	font-style: normal;
	line-height: 85px;
	margin-left: -10px;
	text-shadow: 0 0 30px yellow;
}
.animated {
	-webkit-animation-duration: 1s;
	animation-duration: 1s;
	-webkit-animation-fill-mode: both;
	animation-fill-mode: both
}  
.bounce {
	-webkit-animation-name: bounce; 
	-webkit-transform-origin: center bottom;
	transform-origin: center bottom
}
@-webkit-keyframes bounce {
	0%, 100%, 20%, 53%, 80% {
		-webkit-animation-timing-function: cubic-bezier(0.215, .61, .355, 1);
		animation-timing-function: cubic-bezier(0.215, .61, .355, 1);
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0)
	}
	40%, 43% {
		-webkit-animation-timing-function: cubic-bezier(0.755, .050, .855, .060);
		animation-timing-function: cubic-bezier(0.755, .050, .855, .060);
		-webkit-transform: translate3d(0, -30px, 0);
		transform: translate3d(0, -30px, 0)
	}
	70% {
		-webkit-animation-timing-function: cubic-bezier(0.755, .050, .855, .060);
		animation-timing-function: cubic-bezier(0.755, .050, .855, .060);
		-webkit-transform: translate3d(0, -15px, 0);
		transform: translate3d(0, -15px, 0)
	}
	90% {
		-webkit-transform: translate3d(0, -4px, 0);
		transform: translate3d(0, -4px, 0)
	}
} 
</style>
<div class="login-box">
    <div class="login-logo">
        <span class="logo"><img src="/images/logo_80.png"/></span>
		<i id="app_title">中石油网管系统</i>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->


<?php
$js = <<<abc
$( function () { 
    $('#app_title')
		.addClass('bounce animated')
		.one('webkitAnimationEnd', function(){
				$(this).removeClass('bounce animated');
		});
});
abc;

$this->registerJs($js);
?>