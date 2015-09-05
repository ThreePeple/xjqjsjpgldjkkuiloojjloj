<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\AccessDeviceInfo */

$this->title = 'Create Access Device Info';
$this->params['breadcrumbs'][] = ['label' => 'Access Device Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-device-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
