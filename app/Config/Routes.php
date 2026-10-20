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

$routes->get('producto', 'Producto::index');