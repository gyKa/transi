<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/environment.php';

$db_config = require __DIR__.'/databases/config.php';

$app = new Silex\Application();

$default_db_connection = $db_config['environments']['default_database'];
$app_env = getenv('APP_ENV');

if (isset($app_env) && !empty($app_env)) {
    $default_db_connection = $app_env;
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => [
        'dbname' => $db_config['environments'][$default_db_connection]['name'],
        'user' => $db_config['environments'][$default_db_connection]['user'],
        'password' => $db_config['environments'][$default_db_connection]['pass'],
        'host' => $db_config['environments'][$default_db_connection]['host'],
        'driver' => 'pdo_'.$db_config['environments'][$default_db_connection]['adapter'],
        'charset' => 'utf8',
    ]
]);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app['debug'] = getenv('DEBUG');

$app->get('/', function () use ($app) {
    $vehicles = $app['db']->fetchAll('SELECT id, title FROM vehicles');
    $activities = $app['db']->fetchAll(
        'SELECT
            `activities`.`date`,
            `vehicles`.`id`,
            `vehicles`.`title`,
            `activities`.`distance`
        FROM `activities`
        CROSS JOIN vehicles ON `activities`.`vehicle_id` = `vehicles`.`id`
        ORDER BY `activities`.`date` DESC, `activities`.`id` DESC'
    );

    return $app['twig']->render('index.twig', [
        'vehicles' => $vehicles,
        'activities' => $activities,
    ]);
});

$app->get('/vehicles/{id}', function ($id) use ($app) {
    // Use LEFT JOIN, because there can be exists a vehicle without any '.
    $vehicle = $app['db']->fetchAssoc(
        'SELECT
            vehicles.id,
            vehicles.title,

            SUM(
                IF(
                    activities.date >= DATE_SUB(NOW(), INTERVAL 7 DAY),
                    activities.distance,
                    0
                )
            ) as total_distance_week,

            SUM(
                IF(
                    activities.date >= DATE_SUB(NOW(), INTERVAL 4 WEEK),
                    activities.distance,
                    0
                )
            ) as total_distance_month,

            SUM(
                IF(
                    activities.date >= DATE_SUB(NOW(), INTERVAL 365 DAY),
                    activities.distance,
                    0
                )
            ) as total_distance_year,

            IFNULL(SUM(activities.distance), 0) as total_distance
        FROM vehicles
        LEFT JOIN activities ON vehicles.id = activities.vehicle_id
        WHERE vehicles.id = ?',
        [(int)$id]
    );

    // If vehicle doesn't exists, this value is NULL.
    if (is_null($vehicle['total_distance_week'])) {
        $app->abort(404, 'Vehicle does not exist!');
    }

    $activities = $app['db']->fetchAll(
        'SELECT `date`, `distance` FROM `activities` WHERE vehicle_id = ? ORDER BY `date` DESC, `id` DESC',
        [(int)$id]
    );

    return $app['twig']->render('vehicle.twig', [
        'vehicle' => $vehicle,
        'activities' => $activities,
    ]);
})
->assert('id', '\d+');

$app->get('/vehicles/{id}/add_activity', function ($id) use ($app) {
    $title = $app['db']->fetchColumn(
        'SELECT title FROM vehicles WHERE id = ?',
        [(int)$id]
    );

    return $app['twig']->render('add_activity.twig', [
        'vehicle_id' => $id,
        'vehicle_title' => $title,
    ]);
});

$app->get('/vehicles/add', function () use ($app) {
    return $app['twig']->render('add_vehicle.twig');
});

$app->post('/vehicles', function (Request $request) use ($app) {
    $app['db']->insert('vehicles', ['title' => $request->get('title')]);
    
    $app['session']->getFlashBag()->add('success', 'New vehicle is added!');

    return $app->redirect('/');
});

$app->post('/activities', function (Request $request) use ($app) {
    $vehicle_id = $request->get('vehicle_id');
    $distance = $request->get('distance');
    $date = $request->get('date');

    $id = $app['db']->fetchColumn(
        'SELECT id FROM vehicles WHERE id = ?',
        [(int)$vehicle_id]
    );

    if ($id) {
        $app['db']->insert(
            'activities',
            ['vehicle_id' => $vehicle_id, 'date' => $date, 'distance' => $distance]
        );

        $app['session']->getFlashBag()->add('success', 'New activity is added!');

        return $app->redirect('/vehicles/'.$vehicle_id);
    }

    $app['session']->getFlashBag()->add('danger', 'Vehicle does not exist!');

    return $app->redirect('/');
});

$app->post('/login', function (Request $request) use ($app) {
    $email = $request->get('email');
    $password = $request->get('password');

    $hash = $app['db']->fetchColumn(
        'SELECT password FROM users WHERE email = ? LIMIT 1',
        [$email]
    );

    if (password_verify($password, $hash)) {
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

unset($app_env);

return $app;
