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
                    '<li class="header">报表统计</li>',
                ],
            ]
        );
        ?>

        <ul class="sidebar-menu">
            <li><a href="<?=Url::toRoute('/system/user/index')?>"><span class="fa fa-circle-o"></span> 设备分类统计</a>
            <li><a href="<?=Url::toRoute('/system/user/index')?>"><span class="fa fa-circle-o"></span> 设备运行状态统计</a>
            <li><a href="<?=Url::toRoute('/system/user/index')?>"><span class="fa fa-circle-o"></span> 链路运行状态统计</a>
        </ul>

    </section>

</aside>
