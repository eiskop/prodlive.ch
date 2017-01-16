<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'prodlive',
    'name' => 'JELD-WEN Schweiz AG - ProdLive',
    'language' => 'de',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Aliases'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EX-Uum-SAiAf6Z_BsYtRXSFD5ICkpLHm',
        ],
        // you can set your theme here - template comes with: 'light' and 'dark'
        'view' => [
            'theme' => [
                'pathMap' => ['@app/views' => '@webroot/themes/light/views'],
                'baseUrl' => '@web/themes/light',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                // we will use bootstrap css from our theme
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [], // do not use yii default one
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
           // 'enablePrettyUrl' => true,
           // 'showScriptName' => false,
           // 'rules' => [
           //     '<alias:\w+>' => 'site/<alias>',
           // ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
            'enableAutoLogin' => true,
            'authTimeout' => false,
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'savePath' => '@app/runtime/session'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                     'class' => 'Swift_SmtpTransport',
                     'host' => '10.41.0.172',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                     'username' => 'chsscanner',
                     'password' => 'JeldWen2015',
                     'port' => '587', // Port 25 is a very common port too (587)
                     'encryption' => 'tls', // It is often used, check your provider or mail server             
                     ],
                // send all mails to a file by default. 
                // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
                'useFileTransport' => true,
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    //echo '<pre>', var_dump($_SERVER);
//   $config['components']['db'] = require(__DIR__ . '/db_dev.php');    
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['10.41.4.151'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',    
        'allowedIPs' => ['10.41.4.151'],
    ];
}

return $config;
