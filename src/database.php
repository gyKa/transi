<?php

function getDatabaseConnection($database, $user, $password, $host = '127.0.0.1')
{
    return \Doctrine\DBAL\DriverManager::getConnection(
        getDatabaseParams($database, $user, $password, $host),
        new \Doctrine\DBAL\Configuration()
    );
}

function getDatabaseParams($database, $user, $password, $host)
{
    return [
        'dbname' => $database,
        'user' => $user,
        'password' => $password,
        'host' => $host,
        'driver' => 'pdo_mysql',
        'charset'   => 'utf8',
    ];
}
