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
                    '<li class="header">统计查询</li>',
                ],
            ]
        );
        ?>
        <?=
        Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ["label" => '<span class="fa fa-circle-o"></span> 有线设备查询',"url" => ['/stat/device/index']],
                    ["label" => '<span class="fa fa-circle-o"></span> 无线设备查询',"url" => ['/stat/wireless/index']],
                ],
            ]
        );
        ?>

    </section>

</aside>
