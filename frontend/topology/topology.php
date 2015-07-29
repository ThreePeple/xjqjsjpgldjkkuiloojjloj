<?php

namespace app\topology;

class topology extends \yii\base\Module
{
    public $controllerNamespace = 'app\topology\controllers';

    public $defaultRoute = 'dashboard';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
