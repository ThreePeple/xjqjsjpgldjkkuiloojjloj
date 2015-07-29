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
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>模板管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/system/template/index"><span class="fa fa-circle-o"></span> 大楼局域网模板</a> </li>
                </ul>
            </li>
            <li><a href="<?=Url::toRoute('/system/user/index')?>"><span class="fa fa-circle-o"></span> 用户管理</a>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-circle-o"></i> <span>告警管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><span class="fa fa-file-code-o"></span> 条件设置</a>
                    </li>
                    <li><a href="#"><span class="fa fa-dashboard"></span> 消息发送</a>
                    </li>

                </ul>
            </li>
        </ul>

    </section>

</aside>
