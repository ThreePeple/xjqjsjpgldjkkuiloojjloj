<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DeviceAlarm */

$this->title = '新增用户';

?>
<div class="device-alarm-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
