<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\SmsConfig */

$this->title = 'Update Sms Config: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sms Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sms-config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
