<?php

return [
    'paths' => [
        'migrations' => __DIR__.'/../../migrations'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'transi',
            'user' => 'root',
            'pass' => '',
            'port' => 3306
        ],
        'travis-mysql' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'name' => 'transi',
            'user' => 'travis',
            'pass' => '',
            'port' => 3306
        ],
        'travis-pgsql' => [
            'adapter' => 'pgsql',
            'host' => '127.0.0.1',
            'name' => 'transi',
            'user' => 'postgres',
            'pass' => '',
            'port' => 5432
        ],
        'codeship' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'name' => 'development'.getenv(TEST_ENV_NUMBER),
            'user' => getenv(MYSQL_USER),
            'pass' => getenv(MYSQL_PASSWORD),
            'port' => 3306
        ],
    ]
];
