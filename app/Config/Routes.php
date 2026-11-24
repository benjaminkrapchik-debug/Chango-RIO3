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

$routes->get('productos/vea', 'Productos::vea');
$routes->get('productos/luconi', 'Productos::luconi');
$routes->get('productos/caracol', 'Productos::caracol');

$routes->get('productos/editar/(:num)', 'Productos::editar/$1');

$routes->post('productos/actualizar/(:num)', 'Productos::actualizar/$1');

// MERCADO PAGO
$routes->post('carrito/finalizar', 'Productos::finalizarCompra');

$routes->get('pagos/crear/(:num)', 'Pagos::crear/$1');

$routes->get('pagos/aprobado', 'Pagos::aprobado');
$routes->get('pagos/rechazado', 'Pagos::rechazado');
$routes->get('pagos/pendiente', 'Pagos::pendiente');

$routes->post('pagos/notificacion', 'Pagos::notificacion');