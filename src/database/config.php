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
    ]
];
