<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JumperInfo */

$this->title = '新增记录';
$this->params['breadcrumbs'][] = ['label' => 'Jumper Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>
            <?=$this->title?></h3></div>
    <div class="panel-body">
        <div class="jumper-info-create col-md-8">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>

