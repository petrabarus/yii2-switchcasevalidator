<?php

require dirname(__FILE__) . '/../vendor/autoload.php';
require dirname(__FILE__) . '/../vendor/yiisoft/yii2/Yii.php';

$config = [
    'id' => 'Yii2 Test',
    'basePath' => dirname(__FILE__),
];

$application = new yii\console\Application($config);