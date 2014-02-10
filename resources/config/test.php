<?php
require __DIR__ . '/prod.php';
$app['debug']     = true;
$app['log.level'] = Monolog\Logger::DEBUG;

$app['config.mongo.host']     = 'localhost:27017';
$app['config.mongo.db']       = 'magrathea-test';
$app['config.mongo.username'] = 'zaphod';
$app['config.mongo.password'] = '42';

