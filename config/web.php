<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'CnQjEz6BxyA-enFjbWLonzN3s0xuEz5T',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // กฎการกำหนด URL ที่เป็นมิตร
                'user/update/<id:\d+>' => 'user/update',
//                'user/view/<id:\d+>' => 'user/view',
                'user/view-all' => 'user/view-all',
            ],
        ],
//        'view' => [
//            'class' => 'yii\web\View',
//            'on beforeRender' => function($event) {
//                if (!Yii::$app->user->isGuest) {
//                    $user = Yii::$app->user->identity;
//                    $username = $user->username;
//                    $department = $user->department;
//                    Yii::$app->view->params['username'] = $username;
//                    Yii::$app->view->params['department'] = $department;
//                } else {
//                    // Default values for guests
//                    Yii::$app->view->params['username'] = 'Guest';
//                    Yii::$app->view->params['department'] = 'Guest';
//                }
//            }
//        ]
        'view' => [
            'class' => 'yii\web\View',
            'on beforeRender' => function($event) {
                if (!Yii::$app->user->isGuest) {
                    // ดึงข้อมูลผู้ใช้จาก Users model
                    $user = Yii::$app->user->identity;  // ใช้ model ชื่อ Users
                    // ดึง username จาก Users model
                    $username = $user->username;
                    // ดึงชื่อแผนกจากความสัมพันธ์ใน model
                    $departmentName = $user->departmentRelation ? $user->departmentRelation->department_name : 'บุคคลภายนอก';
                    // ส่งค่าชื่อผู้ใช้และชื่อแผนกไปยัง params
                    Yii::$app->view->params['username'] = $username;
                    Yii::$app->view->params['department'] = $departmentName;
                } else {
                    // ค่า default สำหรับผู้ที่ไม่ได้ล็อกอิน
                    Yii::$app->view->params['username'] = 'Guest';
                    Yii::$app->view->params['department'] = 'บุคคลภายนอก';
                }
            },
        ],


    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
