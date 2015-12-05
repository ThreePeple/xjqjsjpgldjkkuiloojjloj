<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use dmstr\web\AdminLteAsset;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AdminLteAsset
{

    public function init(){
        $this->css[] = '/css/global.css';
        $this->js[] = '/js/utils.js';
        parent::init();
    }
}
