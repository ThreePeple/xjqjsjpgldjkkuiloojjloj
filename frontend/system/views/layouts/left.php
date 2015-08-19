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

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

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
            <li class="treeview <?=($this->context->id == 'template'? "active":'')?>">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>模板管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <?=Nav::widget([
                    "options" => ["class"=>"treeview-menu"],
                    'encodeLabels' => false,
                    "items" => [
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 大厦拓扑模板</a> ',
                            "url" => ['/system/template/building']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 大厦局域网1模板</a> ',
                            "url" => ['/system/template/wlan']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 无线网络模板</a> ',
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
            <li class="<?=($this->context->id == 'tip'? "active":'')?>"><a href="<?=Url::toRoute('/system/tip/index')?>"><span class="fa fa-circle-o"></span> 提示信息设置</a>
            <li class="treeview <?=($this->context->id == 'sms'? "active":'')?>">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>告警管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <?=Nav::widget([
                    "options" => ["class"=>"treeview-menu"],
                    'encodeLabels' => false,
                    "items" => [
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 条件设置</a> ',
                            "url" => ["#"]
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 消息模版</a> ',
                            "url" => ["#"]
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 消息发送</a> ',
                            "url" => ['＃']
                        ],
                        [
                            "label" => '<span class="fa fa-circle-o"></span> 告警查询</a> ',
                            "url" => ['＃']
                        ],
                    ]
                ])
                ?>

            </li>
            <li class="treeview <?=($this->context->id == 'link'? "active":'')?>">
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
            </li>
        </ul>

    </section>

</aside>
