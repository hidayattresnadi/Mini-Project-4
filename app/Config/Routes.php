<?php

use App\Controllers\ProductController;
use App\Controllers\CustomerController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('unauthorized', 'Home::unauthorized');
$routes->get('/products', 'ProductController::index', ['as' => 'products']);
$routes->get('/users/profile', 'CustomerController::showProfile', ['as' => 'profile'], ['filter' => 'role:administrator,product manager,customer']);

$routes->get('/products/statistics', 'ProductController::getViewStatistic', ['as' => 'product_statistic']);
$routes->get('/product-statistics/getStatistics', 'ProductController::getStatistics');

$routes->group('admin/users', ['filter' => 'role:administrator'], function ($routes) {
    $routes->get('/', 'UserController::index', ['as' => 'users']);
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->put('update/(:num)', 'UserController::update/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
    $routes->get('register', 'UserController::create');
    $routes->post('store', 'UserController::store');
});

$routes->group('admin/roles', ['filter' => 'role:administrator'], function ($routes) {
    $routes->get('/', 'RoleController::showRoles', ['as' => 'roles']);
    $routes->get('create', 'RoleController::create');
    $routes->post('create', 'RoleController::store');
});

$routes->group('admin/customers', ['filter' => 'role:administrator'], function ($routes) {
    $routes->get('/', [CustomerController::class, 'index'], ['as' => 'customers']);
    $routes->get('profile/(:num)', [CustomerController::class, 'detail']);
    $routes->get('create', [CustomerController::class, 'addUserForm']);
    $routes->post('store', [CustomerController::class, 'create']);
    $routes->get('edit/(:num)', [CustomerController::class, 'updateUserForm']);
    $routes->put('update/(:num)', [CustomerController::class, 'update']);
    $routes->delete('delete/(:num)',  [CustomerController::class, 'delete']);
    $routes->get('dashboard', 'AdminController::showUserDashboard', ['as' => 'user_dashboard']);
});

$routes->group('admin/products', ['filter' => 'role:administrator,product manager'], function ($routes) {
    $routes->get('/', [ProductController::class, 'getAllProducts'], ['as' => 'admin_products']);
    $routes->get('(:num)', [ProductController::class, 'show'], ['as' => 'product_details']);
    $routes->get('new', [ProductController::class, 'new']);
    $routes->post('create', [ProductController::class, 'create']);
    $routes->get('(:num)/edit', [ProductController::class, 'edit']);
    $routes->put('(:num)', [ProductController::class, 'update']);
    $routes->delete('(:num)',  [ProductController::class, 'delete']);
    $routes->get('dashboard', 'AdminController::showDashboard', ['as' => 'dashboard']);
});

$routes->get('/addUserToGroupForm', 'Auth::addUserToGroupForm', ['filter' => 'role:administrator']);
$routes->post('/addUserToGroup', 'Auth::addUserToGroup', ['filter' => 'role:administrator']);

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    // Route lain seperti login, dll
    $routes->get('login', 'Auth::login', ['as' => 'login']);
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('register', 'Auth::register', ['as' => 'register']);
    $routes->post('register', 'Auth::attemptRegister');
});
