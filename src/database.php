<?php

function getDatabaseConnection($database, $user, $password, $host = '127.0.0.1')
{
    $config = new \Doctrine\DBAL\Configuration();

    $connection_params = [
        'dbname' => $database,
        'user' => $user,
        'password' => $password,
        'host' => $host,
        'driver' => 'pdo_mysql',
        'charset'   => 'utf8',
    ];

    return \Doctrine\DBAL\DriverManager::getConnection($connection_params, $config);
}
