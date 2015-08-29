<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\SmsConfig */

$this->title = 'Create Sms Config';
$this->params['breadcrumbs'][] = ['label' => 'Sms Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        "levels" => $levels,
        "categorys" => $categorys,
        "users" => $users,
        "templates" => $templates
    ]) ?>

</div>
