<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JumperInfo */

$this->title = 'Create Jumper Info';
$this->params['breadcrumbs'][] = ['label' => 'Jumper Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jumper-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
