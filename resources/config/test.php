<?php
require __DIR__ . '/prod.php';
$app['debug']     = true;
$app['log.level'] = Monolog\Logger::DEBUG;

$app['mongodb.host']     = 'localhost:27017';
$app['mongodb.db']       = 'magrathea-test';
$app['mongodb.username'] = 'zaphod';
$app['mongodb.password'] = '42';

