<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SmsTemplate */

$this->title = '编辑模版: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sms Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sms-template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
