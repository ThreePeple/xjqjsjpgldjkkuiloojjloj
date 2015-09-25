<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'authManager'=>[
            'class' => 'yii\rbac\DbManager'
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'timeout' => 300
        ],
        'log' =>[
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'console' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace','info','error', 'warning'],
                    'logVars' =>[],
                    'categories' => ['console/*'],
                    'logFile' => '@app/runtime/logs/console.log',
                ],
                'console_track' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace','info','error', 'warning'],
                    'logVars' =>[],
                    'categories' => ['console/*'],
                    'logFile' => '@app/runtime/logs/console_track.log',
                ],
            ],
        ],

    ],
];
