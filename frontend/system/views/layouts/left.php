<?php
use yii\bootstrap\Nav;
use yii\helpers\Url;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?=
        Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    '<li class="header">系统设置</li>',
                ],
            ]
        );
        ?>

        <ul class="sidebar-menu">
            <li class="<?=($this->context->id == 'user'? "active":'')?>"><a href="<?=Url::toRoute('/system/user/index')?>"><span class="fa fa-circle-o"></span> 用户管理</a>
            <?php
            if(Yii::$app->user->can("admin")){
            ?>
            <li class="treeview <?= ($this->context->id == 'template' ? "active" : '') ?>">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>模板管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <?= Nav::widget([
                    "options" => ["class" => "treeview-menu"],
                    'encodeLabels' => false,
                    "items" => [
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 大厦网络楼层分布图模板</a> ',
                            "url" => ['/system/template/building']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 数据中心网络拓扑图模板</a> ',
                            "url" => ['/system/template/wlan']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 局域网拓扑图模板</a> ',
                            "url" => ['/system/template/wireless']
                        ],
                    ]
                ])
                ?>
                <!--<ul class="treeview-menu">
                    <li><a href="/system/template/building"><span class="fa fa-circle-o"></span> 大楼局域网模板</a> </li>
                    <li><a href="/system/template/wlan"><span class="fa fa-circle-o"></span> 有线网络模板</a> </li>
                    <li><a href="/system/template/wireless"><span class="fa fa-circle-o"></span> 无线网络模板</a> </li>
                </ul>-->
            </li>
            <li class="<?= ($this->context->id == 'tip' ? "active" : '') ?>"><a
                    href="<?= Url::toRoute('/system/tip/index') ?>"><span class="fa fa-circle-o"></span> 提示信息设置</a>
            </li>
            <?php
            }
            ?>
            <li class="treeview <?=(in_array($this->context->id,['device-alarm',"sms",'sms-template'])? "active":'')?>">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>告警管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <?=Nav::widget([
                    "options" => ["class"=>"treeview-menu"],
                    'encodeLabels' => false,
                    "items" => [
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 有线设备告警查询</a> ',
                            "url" => ['/system/device-alarm/index']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 无线设备告警查询</a> ',
                            "url" => ['/system/device-alarm/wireless-list']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 消息设置</a> ',
                            "url" => ["/system/sms/index"]
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 消息模版</a> ',
                            "url" => ["/system/sms-template/index"]
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 告警级别黑名单</a> ',
                            "url" => ["/system/device-alarm/level-blacklist"]
                        ],
                    ]
                ])
                ?>

            </li>
            <!--<li class="treeview <?=($this->context->id == 'link'? "active":'')?>">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>链路管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><span class="fa fa-circle-o"></span> 链路查询</a>
                    </li>
                    <li><a href="#"><span class="fa fa-circle-o"></span> 链路检测</a>
                    </li>

                </ul>
            </li>-->
        </ul>

    </section>

</aside>
