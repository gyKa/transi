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

$app->get('/vehicles/{id}', function ($id) use ($app) {
	// Use LEFT JOIN, because there can be exists a vehicle without any trips.
    $vehicle = $app['db']->fetchAssoc(
        'SELECT
            SUM(IF(trips.date >= DATE_SUB(NOW(), INTERVAL 7 DAY), trips.distance, 0)) as total_distance_week,
            SUM(IF(trips.date >= DATE_SUB(NOW(), INTERVAL 4 WEEK), trips.distance, 0)) as total_distance_month,
            SUM(IF(trips.date >= DATE_SUB(NOW(), INTERVAL 365 DAY), trips.distance, 0)) as total_distance_year,
            IFNULL(SUM(trips.distance), 0) as total_distance
        FROM vehicles
        LEFT JOIN trips ON vehicles.id = trips.vehicle_id
        WHERE vehicles.id = ?',
        [(int)$id]
    );

    // If vehicle doesn't exists, this value is NULL.
    if (is_null($vehicle['total_distance_week'])) {
        $app->abort(404, 'Vehicle does not exist!');
    }

    return $app['twig']->render('vehicle.twig', [
        'vehicle' => $vehicle,
    ]);
});

return $app;
