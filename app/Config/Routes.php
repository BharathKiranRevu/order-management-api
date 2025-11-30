<?php
$routes->setAutoRoute(true);

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// -------------------- API Routes --------------------
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Now CI4 knows where to find Api\Auth controller
    
    $routes->post('register', 'Auth::register');       
    $routes->post('login',    'Auth::login');
    $routes->post('logout',   'Auth::logout');

   // $routes->post('orders', 'Order::create');

   $routes->get('products',             'Products::index');
    $routes->get('products/(:num)',      'Products::show/$1');
    $routes->post('products',            'Products::create');
    $routes->put('products/(:num)',      'Products::update/$1');
    $routes->delete('products/(:num)',   'Products::delete/$1');

   $routes->get('orders',                'Order::index');
    $routes->post('orders',               'Order::create');
    $routes->post('orders/(:num)/cancel', 'Order::cancel/$1');
    // Test routes
    $routes->get('test', function() {
        return "API routing is working!";
    });

    $routes->get('test2', 'Auth::register');                
    $routes->get('test-register', 'Auth::register');
});

$routes->get('dbtest', function () {
    echo "<h1>Testing Raw MySQLi Connection...</h1>";

    $link = @mysqli_connect('127.0.0.1', 'root', '', 'tasknew', 3306);

    if (!$link) {
        echo "<h2 style='color:red'>RAW CONNECTION FAILED</h2>";
        echo "Error: " . mysqli_connect_error() . "<br>";
        echo "Error code: " . mysqli_connect_errno();
        die();
    }

    echo "<h2 style='color:green'>RAW MySQLi CONNECTION SUCCESSFUL!</h2>";
    echo "Connected to database: <strong>tasknew</strong><br>";
    echo "Tables: " . implode(', ', array_column(mysqli_query($link, "SHOW TABLES")->fetch_all(), 0));
    mysqli_close($link);
});

