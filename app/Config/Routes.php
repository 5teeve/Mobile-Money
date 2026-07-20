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

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('prefixes', 'PrefixeController::index');
    $routes->post('prefixes', 'PrefixeController::create');
    $routes->post(
        'prefixes/(:num)', 'PrefixeController::edit/$1');
    $routes->get('prefixes/(:num)/delete', 'PrefixeController::delete/$1');

    $routes->get('types-operation', 'TypeOperationController::index');
    $routes->post('types-operation', 'TypeOperationController::create');
    $routes->post('types-operation/(:num)', 'TypeOperationController::edit/$1');
    $routes->get('types-operation/(:num)/delete', 'TypeOperationController::delete/$1');

    $routes->get('baremes', 'BaremeController::index');
    $routes->post('baremes', 'BaremeController::create');
    $routes->post('baremes/(:num)', 'BaremeController::edit/$1');
    $routes->get('baremes/(:num)/delete', 'BaremeController::delete/$1');

    $routes->get('situation/gains', 'SituationController::gains');
    $routes->get('situation/comptes', 'SituationController::comptes');
});
