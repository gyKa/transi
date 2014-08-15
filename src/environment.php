<?php

Dotenv::load(__DIR__.'/..');

Dotenv::required([
    'DB_NAME',
    'DB_USER',
    'DB_PASS',
]);
