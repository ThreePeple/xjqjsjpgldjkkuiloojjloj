<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-5-11.下午2:28
 * Description:
 */

namespace frontend\widgets\assets;


use yii\web\View;
use yii\web\AssetBundle;

class BoxAsset extends AssetBundle{
    public $sourcePath = '@app/widgets/assets';
    public $css = [
        "css/box.css"
    ];
    public $js = [
        "js/box.js",
    ];
    public $depends = [
        'frontend\widgets\assets\FontawesomeAssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = ['position' => View::POS_HEAD];
}