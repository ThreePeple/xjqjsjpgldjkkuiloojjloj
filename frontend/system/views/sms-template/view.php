<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SmsTemplate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sms Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sms-template-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => ' 确认要删除此模版?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'content:ntext',
        ],
    ]) ?>

</div>
