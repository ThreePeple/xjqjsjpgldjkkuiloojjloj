<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php
NavBar::begin([
    'brandLabel' => '<span class=""><img src="/images/logo_33.png" style="margin-top: -6px;"/></span>  中石油网管系统',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
    'innerContainerOptions' =>[
        'class' => 'container-fluid'
    ]
]);
$menuItems = [
    [
        'label' => '拓扑展示',
        'items' =>[
            [
                'label' => '大厦局域网',
                'url' => ['/topology/dashboard/index']
            ],
            [
                'label' => '有线网络',
                'url' => ['/topology/dashboard/wlan']
            ],
            [
                'label' => '无线网络',
                'url' => ['/topology/dashboard/index']
            ],
            [
                'label' => '交换机组网',
                'url' => ['/topology/dashboard/index']
            ],
        ]
    ],
    [
        'label'=> '接入管理',
        'url' => ['/input/config-set/index']
    ],
    ['label'=> '报表统计'],
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