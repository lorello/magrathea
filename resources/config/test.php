<?php
require __DIR__ . '/prod.php';

putenv('APPLICATION_ENV=testing');

$app['debug']     = true;
$app['log.level'] = Monolog\Logger::DEBUG;

// raw errors are probably more readable during tests
$app['exception_handler']->disable();
