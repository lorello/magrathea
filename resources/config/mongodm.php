<?php
return array(

    'default'     => array(
        'connection' => array(
            'hostnames' => 'localhost',
            'database'  => 'magrathea',
        )
    ),
    'development' => array(
        'connection' => array(
            'hostnames' => 'localhost',
            'database'  => 'magrathea-dev',
        )
    ),
    'testing'     => array(
        'connection' => array(
            'hostnames' => 'localhost',
            'database'  => 'magrathea-test',
        )
    ),
    'production'  => array(
        'connection' => array(
            'hostnames' => getenv('MONGODB_HOST') . ':' . getenv('MONGODB_PORT'),
            'database'  => getenv('MONGODB_DATABASE'),
            'username'  => getenv('MONGODB_USERNAME'),
            'password'  => getenv('MONGODB_PASSWORD'),
        )
    )
);
