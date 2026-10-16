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
 
 $routes->get('dashboard', 'Dashboard::index');
 $routes->post('logout', 'Auth::logout');

 $routes->get('login', 'Auth::login');
$routes->post('iniciarSesion', 'Auth::iniciarSesion');

$routes->get('register', 'Auth::register');
$routes->post('registrar', 'Auth::registrar');

$routes->get('dashboard', 'Auth::dashboard');
$routes->get('logout', 'Auth::logout');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('dashboard', 'Auth::dashboard');
$routes->get('logout', 'Auth::logout');