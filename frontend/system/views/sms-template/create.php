<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\SmsTemplate */

$this->title = '新建模版';
$this->params['breadcrumbs'][] = ['label' => 'Sms Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
