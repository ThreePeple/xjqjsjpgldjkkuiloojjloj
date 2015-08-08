<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-14.下午4:16
 * Description:
 */

namespace frontend\widgets;

use yii\web\AssetBundle;

class DataTableAsset extends AssetBundle{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datatables/';
    public $css = [
        "jquery.dataTables.min.css",
        "dataTables.bootstrap.css",
    ];
    public $js = [
        "jquery.dataTables.min.js",
        "dataTables.bootstrap.min.js",
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [];
} 