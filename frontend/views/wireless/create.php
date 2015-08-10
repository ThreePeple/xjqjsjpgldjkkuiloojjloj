<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WirelessDeviceInfo */

$this->title = 'Create Wireless Device Info';
$this->params['breadcrumbs'][] = ['label' => 'Wireless Device Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wireless-device-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
