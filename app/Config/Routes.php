<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route untuk halaman utama
$routes->get('/', 'Home::index');

// Grouping routes untuk API dengan namespace App\Controllers
$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->post('employees', 'EmployeeController::create');
    $routes->get('employees', 'EmployeeController::index');
    $routes->put('employees/(:num)', 'EmployeeController::update/$1');
    $routes->delete('employees/(:num)', 'EmployeeController::delete/$1');
});
