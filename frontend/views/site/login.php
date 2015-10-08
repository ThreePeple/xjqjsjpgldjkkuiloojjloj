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
.login-box{
	width:400px;
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
.login-logo  i.shown{
	opacity: 1;
}
.animated {
	-webkit-animation-duration: 1s;
	animation-duration: 1s;
	-webkit-animation-fill-mode: both;
	animation-fill-mode: both;
} 
.animated.bounceIn{
	-webkit-animation-duration:.75s;
	animation-duration:.75s;
}
.bounceIn{
	-webkit-animation-name:bounceIn;
	animation-name:bounceIn
}
@-webkit-keyframes bounceIn{
	0%,100%,20%,40%,60%,80%{
		-webkit-animation-timing-function:cubic-bezier(0.215,.61,.355,1);
		animation-timing-function:cubic-bezier(0.215,.61,.355,1)
	}
	0%{
		opacity:0;
		-webkit-transform:scale3d(.3,.3,.3);
		transform:scale3d(.3,.3,.3)
	}
	20%{
		-webkit-transform:scale3d(1.1,1.1,1.1);
		transform:scale3d(1.1,1.1,1.1)
	}
	40%{
		-webkit-transform:scale3d(.9,.9,.9);
		transform:scale3d(.9,.9,.9)
	}
	60%{
		opacity:1;
		-webkit-transform:scale3d(1.03,1.03,1.03);
		transform:scale3d(1.03,1.03,1.03)
	}
	80%{
		-webkit-transform:scale3d(.97,.97,.97);
		transform:scale3d(.97,.97,.97)
	}
	100%{
		opacity:1;
		-webkit-transform:scale3d(1,1,1);
		transform:scale3d(1,1,1)
	}
}
</style>
<div class="login-box">
    <div class="login-logo">
        <span class="logo"><img src="/images/logo_80.png" width="80" height="77" alt="石油大厦网关系统" title="石油大厦网关系统" /></span>
		<i id="app_title" title="石油大厦网关系统">石油大厦网关系统</i>
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
		.addClass('bounceIn animated')
		.one('webkitAnimationEnd', function(){
				$(this).removeClass('bounceIn animated');
		});
});
abc;

$this->registerJs($js);
?>