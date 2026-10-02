<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::login');
$routes->post('/iniciarSesion', 'Auth::iniciarSesion');

$routes->get('/register', 'Auth::register');
$routes->post('/guardarRegistro', 'Auth::guardarRegistro');

$routes->get('/logout', 'Auth::logout');
$routes->get('/home', 'Home::index');

$routes->get('/productos', 'Productos::index');
$routes->get('/productos/nuevo', 'Productos::nuevo');
$routes->post('/productos/guardar', 'Productos::guardar');

$routes->get('/productos/editar/(:num)', 'Productos::editar/$1');
$routes->post('/productos/actualizar/(:num)', 'Productos::actualizar/$1');

$routes->get('/productos/eliminar/(:num)', 'Productos::eliminar/$1');
