<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$route = require __DIR__ . '/route.php';
return [
    'id' => 'didi-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        //全局内容协商
        [
            //ContentNegotiator 类可以分析request的header然后指派所需的响应格式给客户端，不需要我们人工指定
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => yii\web\Response::FORMAT_JSON,
                'application/xml' => yii\web\Response::FORMAT_XML,
                //api 端目前只需要json 和 xml
                //还可以增加 yii\web\Response 类内置的响应格式，或者自己增加响应格式
            ],
        ]
    ],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'as beforeSend' => [
                'class' => 'api\widgets\BeforeSendBehavior',
                'defaultCode' => 500,
                'defaultMsg' => 'error',
            ],
            //ps：components 中绑定事件，可以用两种方法
            //'on eventName' => $eventHandler,
            //'as behaviorName' => $behaviorConfig,
            //参考 http://www.yiiframework.com/doc-2.0/guide-concept-configurations.html#configuration-format

        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
//            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the api
//            'name' => 'advanced-api',
//        ],
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
            'errorAction' => 'site/error',
        ],
        /**/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => $route,
        ],

    ],
    'params' => $params,
];
