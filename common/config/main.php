<?php
return [
	'language' => 'zh-CN',
	'sourceLanguage' => 'zh-CN',
    'defaultRoute' =>'index',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
