<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$css = <<<CSS
        .dropdown-menu{ padding: 1px 0;}
        .dropdown.open > .dropdown-menu{ -webkit-animation: open_topology_submenu 0.2s; }
        @-webkit-keyframes open_topology_submenu { from { margin-top: -15px; opacity: 0;; } 95% { margin-top: -3px; opacity: 0.9; } to { margin-top: 0; opacity: 1; }  }
        .dropdown:hover .menu-top{display:block;}
        .dropdown.open a.dropdown-toggle{z-index: 1100;box-shadow: 0 0 8px 0px #fff; background-color: rgba(255,255,255,0.987) !important; color: #080808 !important; }
        .dropdown-submenu{position:relative;}
        .dropdown-menu li > a {padding-top: 9px; padding-bottom: 9px; }
        .dropdown-menu .divider{ margin: 0 !important;}
        .dropdown-menu { box-shadow: 0 0 8px 0px #fff; background-color: rgba(255,255,255,0.987); }
        .dropdown.open .dropdown-menu{ margin-top: -1px; }
        .dropdown-submenu > .dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
        .dropdown-submenu:hover > .dropdown-menu{display:block;}
        .dropdown-submenu > a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
        .dropdown-submenu:hover > a:after{border-left-color:#ffffff;}
        .dropdown-submenu > .dropdown-menu{ }
        .dropdown-submenu:hover > .dropdown-menu{ -webkit-animation: open_submenu 0.3s; }
        @-webkit-keyframes open_submenu { from { margin-left: -20px; opacity: 0;; } 90% { margin-left: 5px; opacity: 0.9; } to { margin-left: 0; opacity: 1; }  }
        .dropdown-submenu .pull-left{float:none;}
        .dropdown-submenu.pull-left > .dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}
CSS;
$this->registerCss($css);
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
$active = Yii::$app->controller->module->getUniqueId();

$action = Yii::$app->controller->action->getUniqueId();

$menuItems = [
    [
        'label' => '拓扑展示',
        'items' =>[
            [
                'label' => '大厦网络楼层分布图',
                'url' => ['/topology/dashboard/index'],
                'active' => ""
            ],
            '<li role="separator" class="divider"></li>',
            [
                "label" =>"有线网络",
                "url" => "/topology/dashboard/wlan",
                "items" => [
                    [
                        "label"=>"数据中心网络拓扑图",
                        "url"=>["/topology/dashboard/wlan"],
                        "options" => ["class"=>($action == 'topology/dashboard/wlan'? 'active':'')]
                    ],
                    [
                        "label"=>"局域网拓扑图",
                        "url"=>"/topology/dashboard/hub-compose",
                        "options" => ["class"=>($action == 'topology/dashboard/hub-compose'? 'active':'')]
                    ]
                ],
                'active' => in_array($action,['topology/dashboard/wlan','topology/dashboard/hub-compose'])
            ],
            '<li role="separator" class="divider"></li>',
            [
                'label' => '无线网络',
                'url' => ['/topology/dashboard/wireless'],
                "items" => [
                    [
                        "label"=>"核心区域拓扑图",
                        "url"=>["/topology/dashboard/wireless"],
                        "options" => ["class"=>($action == 'topology/dashboard/wireless'? 'active':'')]
                    ],
                    [
                        "label"=>"接入网络拓扑图",
                        "url"=>"/topology/dashboard/wireless-hub",
                        "options" => ["class"=>($action == 'topology/dashboard/wireless-hub'? 'active':'')]
                    ],
                    [
                        "label"=>"AC/AP拓扑图",
                        "url"=>"/topology/dashboard/ac-ap",
                        "options" => ["class"=>($action == 'topology/dashboard/ac-ap'? 'active':'')]
                    ]
                ],
                'active' => in_array($action,['topology/dashboard/wireless','topology/dashboard/wireless-hub',
                    'topology/dashboard/ac-ap'])
            ],
        ],
        'active' => $active == 'topology'
    ],
    [
        'label'=> '接入管理',
        'url' => ['/input/jumper/index'],
        'active' => $active == 'input'
    ],
    [
        'label'=> '查询统计',
        'url' =>['/stat/device/index'],
        /*
        'items' =>[
            [
                'label' => '有线设备查询',
                'url' => ['/stat/device/index'],
            ],
            [
                'label' => '无线设备查询',
                'url' => ['/stat/wireless/index'],
            ],
        ],
        */
        'active' => $active == 'stat'
    ],
    [
        'label' => '系统管理',
        'url' => ['/system'],
        'active' => $active == 'system'
    ],
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
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    //'route' => $active
]);
NavBar::end();
?>