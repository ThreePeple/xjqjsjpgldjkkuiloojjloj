<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DeviceInfo */

$this->title = 'Create Device Info';
$this->params['breadcrumbs'][] = ['label' => 'Device Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
