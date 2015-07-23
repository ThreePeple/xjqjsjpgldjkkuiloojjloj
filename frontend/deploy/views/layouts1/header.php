<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php
NavBar::begin([
    'brandLabel' => '中石油网管系统',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    ['label' => '网络拓扑展示', 'url' => ['/topology/default/index']],
    ['label' => '查询统计', 'url' => ['/stat/default/index']],
    ['label' => '系统管理', 'url' => ['/system/default/index']],
];

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>