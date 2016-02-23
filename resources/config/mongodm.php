<?php

return [
    /*
        'default'     => array(
            'connection' => array(
                'hostnames' => 'localhost',
                'database'  => 'magrathea',
            )
        ),
    */
    'development' => [
        'connection' => [
            'hostnames' => 'localhost',
            'database'  => 'magrathea-dev',
        ],
    ],
    'testing'     => [
        'connection' => [
            'hostnames' => 'localhost',
            'database'  => 'magrathea-test',
        ],
    ],
    'production'  => [
        'connection' => [
            'hostnames' => getenv('MONGODB_HOST').':'.getenv('MONGODB_PORT'),
            'database'  => getenv('MONGODB_DATABASE'),
            'username'  => getenv('MONGODB_USERNAME'),
            'password'  => getenv('MONGODB_PASSWORD'),
        ],
    ],
];
