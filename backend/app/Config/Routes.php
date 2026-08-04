<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->post('register', 'Api\AuthController::register');
    $routes->post('login', 'Api\AuthController::login');
    $routes->get('anime', 'Api\AnimeController::index');
    $routes->get('anime/search', 'Api\AnimeController::search');
    $routes->get('anime/(:num)', 'Api\AnimeController::show/$1');
    $routes->get('profile', 'Api\AuthController::profile', ['filter' => 'jwtAuth']);
    $routes->get('favorites', 'Api\FavoriteController::index', ['filter' => 'jwtAuth']);
    $routes->post('favorites', 'Api\FavoriteController::create', ['filter' => 'jwtAuth']);
    $routes->delete('favorites/(:num)', 'Api\FavoriteController::delete/$1', ['filter' => 'jwtAuth']);
});