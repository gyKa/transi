<?php

use Symfony\Component\HttpFoundation\Request;

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

$app->register(new Silex\Provider\SessionServiceProvider());

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
            vehicles.id,
            vehicles.title,
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

    $activities = $app['db']->fetchAll(
        'SELECT `date`, `distance` FROM `trips` WHERE vehicle_id = ? ORDER BY `id` DESC',
        [(int)$id]
    );

    return $app['twig']->render('vehicle.twig', [
        'vehicle' => $vehicle,
        'activities' => $activities,
    ]);
});

$app->get('/vehicles/{id}/add_trip', function ($id) use ($app) {
    $title = $app['db']->fetchColumn(
        'SELECT title FROM vehicles WHERE id = ?',
        [(int)$id]
    );

    return $app['twig']->render('add_trip.twig', [
        'vehicle_id' => $id,
        'vehicle_title' => $title,
    ]);
});

$app->post('/trips', function (Request $request) use ($app) {
    $vehicle_id = $request->get('vehicle_id');
    $distance = $request->get('distance');

    $id = $app['db']->fetchColumn(
        'SELECT id FROM vehicles WHERE id = ?',
        [(int)$vehicle_id]
    );

    if ($id) {
        $app['db']->insert(
            'trips',
            ['vehicle_id' => $vehicle_id, 'date' => date('Y-m-d'), 'distance' => $distance]
        );

        $app['session']->getFlashBag()->add('success', 'New trip is added!');

        return $app->redirect('/vehicles/'.$vehicle_id);
    }

    $app['session']->getFlashBag()->add('danger', 'Vehicle does not exist!');

    return $app->redirect('/');
});

$app->post('/login', function (Request $request) use ($app) {
    $email = $request->get('email');
    $password = $request->get('password');

    if ($email === getenv('ADMIN_EMAIL') && $password === getenv('ADMIN_PASS')) {
        $app['session']->set('admin_mode', true);
    } else {
        $app['session']->getFlashBag()->add('danger', 'The email or password is incorrect!');
    }

    return $app->redirect('/');
});

$app->get('/logout', function () use ($app) {
    $app['session']->invalidate();

    return $app->redirect('/');
});

return $app;
