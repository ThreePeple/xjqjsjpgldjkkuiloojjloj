<?php

namespace frontend\controllers;

use app\models\DeviceLink;
use app\models\RestfulClient;

class QueryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest(){
        $a = ['a'=>[1,2]];

        $key = ($t = array_search([2,1],$a))? $t : ($t= array_search([1,2],$a)? $t: '');
        var_dump($key);

        if($t = array_search([2,1],$a) || ($t = array_search([1,2],$a)) ){
            var_dump($t);
        }else{
            echo '11111';
        }
    }
}
