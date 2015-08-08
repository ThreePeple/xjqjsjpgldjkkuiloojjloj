<?php

namespace app\stat;

class stat extends \yii\base\Module
{
    public $controllerNamespace = 'app\stat\controllers';
    public $layout='//main1';
    public $defaultRoute = 'device';
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
