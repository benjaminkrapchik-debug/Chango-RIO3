<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');


$routes->get('login', 'Auth::login');
$routes->post('iniciarSesion', 'Auth::iniciarSesion');

$routes->get('register', 'Auth::register');
$routes->get('registro', 'Auth::register');
$routes->post('guardarRegistro', 'Auth::guardarRegistro');


$routes->get('inicio', 'Auth::inicio');
$routes->post('logout', 'Auth::logout');


$routes->get('productos', 'Productos::index');
$routes->post('productos/guardar', 'Productos::guardar');
$routes->post('productos/eliminar/(:num)', 'Productos::eliminar/$1');


$routes->post('carrito/agregar/(:num)', 'Productos::agregarCarrito/$1');
$routes->post('carrito/eliminar/(:num)', 'Productos::eliminarCarrito/$1');
$routes->post('carrito/vaciar', 'Productos::vaciarCarrito');


$routes->get('supermercados', 'supermercados::index');
$routes->get('historial', 'Historial::index');

$routes->post('carrito/finalizar', 'Productos::finalizarCompra');