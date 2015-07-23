<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php
NavBar::begin([
    'brandLabel' => '<span class="logo"><img src="/images/logo.png"/></span>中石油网管系统',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
    'innerContainerOptions' =>[
        'class' => 'container-fluid'
    ]
]);
$menuItems = [
    ['label' => '网络拓扑展示', 'url' => ['/topology']],
    ['label' => '查询统计', 'url' => ['/stat']],
    ['label' => '系统管理', 'url' => ['/system']],
    '<li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/images/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">'.Yii::$app->user->identity->username.'</span>
                    </a>
                    <ul class="dropdown-menu">

                        <li class="user-footer">
                            '.Html::a(
        '退出登录',
        ['/site/logout'],
        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
    ) .'
                        </li>
                    </ul>
                </li>'
];
$active = Yii::$app->controller->module->getUniqueId();
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    'route' => $active
]);
NavBar::end();
?>