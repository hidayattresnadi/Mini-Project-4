<?php

use App\Controllers\ProductController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/products', 'ProductController::index', ['as' => 'products']);
$routes->get('/users/profile', 'UserController::showProfile', ['as' => 'profile']);
$routes->get('/products/statistics', 'ProductController::getViewStatistic', ['as' => 'product_statistic']);
$routes->get('/product-statistics/getStatistics', 'ProductController::getStatistics');

$routes->get('/admin/dashboard', 'AdminController::showDashboard', ['as' => 'dashboard']);
$routes->get('/admin/user/dashboard', 'AdminController::showUserDashboard', ['as' => 'user_dashboard']);

$routes->get('admin/users', [UserController::class, 'index'], ['as' => 'users']);
$routes->get('admin/users/profile/(:num)', [UserController::class, 'detail']);
$routes->get('admin/users/create', [UserController::class, 'addUserForm']);
$routes->post('admin/users/store', [UserController::class, 'create']);
$routes->get('admin/users/edit/(:num)', [UserController::class, 'updateUserForm']);
$routes->put('admin/users/update/(:num)', [UserController::class, 'update']);
$routes->delete('admin/users/delete/(:num)',  [UserController::class, 'delete']);

$routes->get('admin/products', [ProductController::class, 'getAllProducts'], ['as' => 'admin_products']);
$routes->get('admin/products/(:num)', [ProductController::class, 'show'], ['as' => 'product_details']);
$routes->get('admin/products/new', [ProductController::class, 'new']);
$routes->post('admin/products/create', [ProductController::class, 'create']);
$routes->get('admin/products/(:num)/edit', [ProductController::class, 'edit']);
$routes->put('admin/products/(:num)', [ProductController::class, 'update']);
$routes->delete('admin/products/(:num)',  [ProductController::class, 'delete']);
