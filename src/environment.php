<?php

/* There are some environment variables:
 * > APP_ENV - sets aplication environment (default - development);
 * > DEBUG - turns on or turns off debug mode;
 * > DB_ADAPTER
 * > DB_HOST
 * > DB_NAME
 * > DB_USER
 * > DB_PASS
 * > DB_PORT
 */

switch(getenv('APP_ENV')) {
    case 'heroku-cleardb':
        $url = parse_url(getenv('CLEARDB_DATABASE_URL'));

        putenv('DB_NAME='.substr($url['path'], 1));
        putenv('DB_USER='.$url['user']);
        putenv('DB_PASS='.$url['pass']);
        putenv('DB_HOST='.$url['host']);
        break;

    default:
        Dotenv::load(__DIR__.'/..');
        break;
}
