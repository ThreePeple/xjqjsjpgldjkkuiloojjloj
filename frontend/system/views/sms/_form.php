<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model frontend\models\SmsConfig */
/* @var $form yii\widgets\ActiveForm */

$categories = json_encode($categorys);
$levels = json_encode($levels);

$this->registerCssFile('/js/select2/css/select2.min.css',["depends"=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/select2/js/select2.min.js',["depends"=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/sms_condition.js',["depends"=>'frontend\assets\AppAsset']);
$js = <<<JS
ConEditor.init({
    containerId:'condition',
    categories: $categories,
    levels: $levels
});
JS;

$this->registerJs($js);

$css = <<<CSS
.condition-contain,.condition-key,.condition-val{
    width: 200px;
}
.condition-val{
    height: 28px;
}
.form-group{
    margin-top: 10px;
}

CSS;
$this->registerCss($css);
?>

<?php
$form=ActiveForm::begin([
    'type' => ActiveForm::TYPE_INLINE

]);
?>
<div class="sms-config-form">
    <div class="panel panel-default">
        <div class="panel-heading">接收用户</div>
        <div class="panel-body">
            <?=$form->field($model,"receivers")->widget(Select2::className(),[
                "data" => $users,
                'options' => ['placeholder' => '选择接收用户'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ])?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">消息模版</div>
        <div class="panel-body">
            <?=$form->field($model,"smsTemplate_id")->widget(Select2::className(),[
                "data" => $templates,
                'options' => ['placeholder' => '选择消息模版'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true
                ],
            ])?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">告警条件设置</div>
        <div class="panel-body" id="condition">

        </div>
    </div>


</div>
<?php
$form->end();
?>