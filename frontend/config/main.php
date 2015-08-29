<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'api' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace','info','error', 'warning'],
                    'logVars' =>[],
                    'categories' => ['curl/*'],
                    'logFile' => '@app/runtime/logs/curl.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'modules' =>[
        'topology' => 'app\topology\topology', //拓扑展示
        'deploy' => 'app\deploy\deploy',
        'stat' => 'app\stat\stat',
        'system' => 'app\system\system',//系统设置
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'input' => [ //接入管理
            'class' => 'app\input\input',
        ],
        'report' => [ //报表管理
            'class' => 'app\report\report',
        ],
    ],
    'params' => $params,
];
