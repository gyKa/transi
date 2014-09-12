<?php

// $url = parse_url(getenv('CLEARDB_DATABASE_URL'));
$url = parse_url('mysql://adffdadf2341:adf4234@us-cdbr-east.cleardb.com/heroku_db?reconnect=true');

$host = $url['host'];
$user = $url['user'];
$pass = $url['pass'];
$db = substr($url['path'], 1);

$env_file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'.env';
$content = "DB_ADAPTER=mysql\nDB_PORT=3306\nDB_NAME=$db\nDB_USER=$user\nDB_PASS=$pass\nDB_HOST=$host\nAPP_ENV=production\n";

file_put_contents($env_file, $content);

return 0;