<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-5-11.下午3:23
 * Description:
 */

namespace frontend\widgets\assets;


use yii\web\AssetBundle;

class FontawesomeAssetBundle extends AssetBundle{
    /**
     * @inherit
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    /**
     * @inherit
     */
    public $css = [
        'css/font-awesome.min.css',
    ];

    /**
     * Initializes the bundle.
     * Set publish options to copy only necessary files (in this case css and font folders)
     */
    public function init()
    {
        parent::init();

        $this->publishOptions['beforeCopy'] = function ($from, $to) {
            return preg_match('%(/|\\\\)(fonts|css)%', $from);
        };
    }
} 