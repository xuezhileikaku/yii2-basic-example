<?php
return [
//                \api\controllers\WechatController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'wechat',
        'extraPatterns' => [
            'POST login' => 'login',
            'POST register' => 'register',
            'GET message' => 'message',
            'GET search' => 'search',
            'POST setting' => 'setting',
            'POST bind' => 'bind',

            'POST charge' => 'charge',
            'POST send' => 'send',
        ],
        'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//                \api\controllers\QuestionController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'question',
        'extraPatterns' => [
            'POST search' => 'search',
            'POST detail' => 'detail',
            'POST userques' => 'userques',
            'POST ask' => 'ask',
        ],
        'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//                \api\controllers\IssueController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'issue',
        'extraPatterns' => [
            'POST list' => 'list',
            'GET new' => 'new',
            'GET hot' => 'hot',
            'POST issue' => 'issue',
            'POST userissue' => 'userissue',
            'POST cancel' => 'cancel',
            'POST beforepay' => 'beforepay',
            'POST pay' => 'pay',
            'GET ispaid' => 'ispaid',
            'POST startview' => 'startview',
            'POST seeans' => 'seeans',
            'POST vote' => 'vote',
        ],
        'tokens' => ['accessToken' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//                \api\controllers\OrderController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'order',
        'extraPatterns' => [
            'POST all' => 'all',
        ],
        'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//                \api\controllers\FilesController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'files',
        'extraPatterns' => [
            'POST upload' => 'upload',
            'POST base64' => 'base64'
        ],
        'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//                \api\controllers\AuthController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'auth',
        'extraPatterns' => [
            'GET resource' => 'resource',
            'POST token' => 'token',
            'POST authorize' => 'authorize',


        ],
//                    'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api',
        'extraPatterns' => [
            'GET test' => 'test',


        ],
//                    'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//                \api\controllers\AliyunController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'aliyun',
        'extraPatterns' => [
            'POST bindphone' => 'bindphone',
            'POST verifycode' => 'verifycode',

        ],
//                    'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
//    \api\controllers\MessageController::className()
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'message',
        'extraPatterns' => [
            'POST submess' => 'submess',
            'POST notify' => 'notify',

        ],
//                    'tokens' => ['{id}' => '<id:\\w+>'],
        'pluralize' => false//禁用urlRule控制器自动复数
    ],
];
?>

