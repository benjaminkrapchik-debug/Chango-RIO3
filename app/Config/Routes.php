<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('iniciarSesion', 'Auth::iniciarSesion');

$routes->get('register', 'Auth::register');
$routes->post('guardarRegistro', 'Auth::guardarRegistro');

$routes->get('dashboard', 'Auth::dashboard');
$routes->get('logout', 'Auth::logout');

$routes->get('productos', 'Productos::index');

$routes->get('productos', 'Producto::index');
$routes->get('productos/nuevo', 'Producto::nuevo');
$routes->post('productos/guardar', 'Producto::guardar');
$routes->get('productos/editar/(:num)', 'Producto::editar/$1');
$routes->post('productos/actualizar/(:num)', 'Producto::actualizar/$1');
$routes->post('productos/eliminar/(:num)', 'Producto::eliminar/$1');
