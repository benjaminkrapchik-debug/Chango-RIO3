<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


 $routes->get('login', 'Auth::login');
 $routes->post('iniciarSesion', 'Auth::iniciarSesion');
 
 $routes->get('register', 'Auth::register');
 $routes->post('guardarRegistro', 'Auth::guardarRegistro');
 
 $routes->get('dashboard', 'Dashboard::index');
 $routes->post('logout', 'Auth::logout');
