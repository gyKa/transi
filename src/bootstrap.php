<?php

require __DIR__.'/environment.php';
require __DIR__.'/database.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => getDatabaseParams(
        getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_HOST')
    )
]);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app['debug'] = getenv('DEBUG');

$app->get('/', function () use ($app) {
    $vehicles = $app['db']->fetchAll('SELECT id, title FROM vehicles');

    return $app['twig']->render('index.twig', [
        'vehicles' => $vehicles,
    ]);
});

return $app;
