<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('client', ['namespace' => 'App\Controllers\Client'], function ($routes) {
    $routes->get('login', 'AuthController::showLogin');
    $routes->post('login', 'AuthController::login');
    $routes->get('logout', 'AuthController::logout');

    $routes->get('dashboard', 'CompteController::index');
    $routes->get('operations', 'OperationController::index');
    $routes->post('operations/depot', 'OperationController::depot');
    $routes->post('operations/retrait', 'OperationController::retrait');
    $routes->post('operations/transfert', 'OperationController::transfert');
    $routes->get('historique', 'HistoriqueController::index');
});
