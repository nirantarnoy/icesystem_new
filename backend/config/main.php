<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
//        'api' => [
//            'class' => 'backend\modules\api\Api',
//            // 'basePath' => '@backend/modules/api',
//            // 'class' => 'backend\modules\api\Module',
//        ],
    ],
    'timeZone' => 'Asia/Bangkok',
//    'aliases'=>[
//        '@adminlte3' => '@backend/theme/AdminLTE-3.0.1',
//    ],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@backend/theme/views'
                ],
            ],
        ],
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@backend/views' => '@adminlte3/views'
//                ],
//            ],
//        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => true // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
//        'request' => [
//            'csrfParam' => '_csrf-backend',
//            'enableCsrfValidation' => false,
//        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'class' => 'yii\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
//            'parsers' => [
//                'application/json'=> \yii\web\JsonParser::class,
//            ]
        ],
//        [
//            'session' =>[
//              //  'timeout' => 86400,
//                'timeout' => 60*60*24*14,
//            ]
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'timeout' => 60*60*24*14,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site_/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
