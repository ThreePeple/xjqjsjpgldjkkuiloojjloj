<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WirelessDeviceInfo */

$this->title = 'Update Wireless Device Info: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wireless Device Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wireless-device-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
