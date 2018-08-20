<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver'      => 'mysql',
            'host'        => env('DB_WEB_HOST', '127.0.0.1'),
            'port'        => env('DB_WEB_PORT', '3306'),
            'database'    => env('DB_WEB_DATABASE', 'web'),
            'username'    => env('DB_WEB_USERNAME', 'homestead'),
            'password'    => env('DB_WEB_PASSWORD', 'secret'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset'     => 'utf8mb4',
            'collation'   => 'utf8mb4_unicode_ci',
            'prefix'      => '',
            'strict'      => true,
            'engine'      => null,
        ],

        'account' => [
            'driver'    => 'mysql',
            'host'      => env('DB_ACCOUNT_HOST', '127.0.0.1'),
            'port'      => env('DB_ACCOUNT_PORT', '3306'),
            'database'  => env('DB_ACCOUNT_DATABASE', 'account'),
            'username'  => env('DB_ACCOUNT_USERNAME', 'homestead'),
            'password'  => env('DB_ACCOUNT_PASSWORD', 'secret'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],

        'player' => [
            'driver'    => 'mysql',
            'host'      => env('DB_PLAYER_HOST', '127.0.0.1'),
            'port'      => env('DB_PLAYER_PORT', '3306'),
            'database'  => env('DB_PLAYER_DATABASE', 'player'),
            'username'  => env('DB_PLAYER_USERNAME', 'homestead'),
            'password'  => env('DB_PLAYER_PASSWORD', 'secret'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],

        'log' => [
            'driver'    => 'mysql',
            'host'      => env('DB_PLAYER_HOST', '127.0.0.1'),
            'port'      => env('DB_PLAYER_PORT', '3306'),
            'database'  => env('DB_PLAYER_DATABASE', 'log'),
            'username'  => env('DB_PLAYER_USERNAME', 'homestead'),
            'password'  => env('DB_PLAYER_PASSWORD', 'secret'),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [
        'client' => 'predis',

        'default' => [
            'host'         => env('REDIS_HOST', '127.0.0.1'),
            'password'     => env('REDIS_PASSWORD', null),
            'port'         => env('REDIS_PORT', 6379),
            'database'     => 0,
            'read_timeout' => 60,
        ],
    ],
];
