<?php

return [
    'externalApi' => [
        'pokeapi' => [
            'baseUrl' => 'https://pokeapi.co/api/v2'
        ]
    ],
    'templatePresentation' => [
        'viewsPath' => __DIR__ . '/../views',
        'cachePath' => __DIR__ . '/../runtime/cache',
        'enableCache' => $_ENV['APP_ENV'] === 'production'
    ],
    'database' => [
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'dbname' => $_ENV['DB_DATABASE'],
        'charset' => $_ENV['DB_CHARSET']
    ],
    'cache' => [
        'host' => $_ENV['REDIS_HOST'],
        'port' => $_ENV['REDIS_PORT'],
        'password' => $_ENV['REDIS_PASSWORD'],
        'params' => [
            'enabled' => CACHE_ENABLE,
            'prefixes' => [
                'pokemon' => 'pokeapi:pokemon:'
            ]
        ]
    ]
];