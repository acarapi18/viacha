<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('unidad_educativa', 'UnidadEducativaController::index');
$routes->post('unidad_educativa/store', 'UnidadEducativaController::store');
$routes->post('unidad_educativa/update/(:num)', 'UnidadEducativaController::update/$1');
$routes->post('unidad_educativa/delete/(:num)', 'UnidadEducativaController::delete/$1');
$routes->get('unidad_educativa/getUnidadEducativa/(:num)', 'UnidadEducativaController::getUnidadEducativa/$1');

$routes->get('login', 'LoginController::index');
$routes->post('login/auth', 'LoginController::auth');
$routes->get('logout', 'LoginController::logout');

$routes->get('/', 'DashboardController::index');
$routes->get('dashboard', 'DashboardController::index');
$routes->get('roles', 'RoleController::index');
$routes->post('roles/store', 'RoleController::store');
$routes->post('roles/update/(:num)', 'RoleController::update/$1');
$routes->post('roles/delete/(:num)', 'RoleController::delete/$1');
$routes->get('roles/getRole/(:num)', 'RoleController::getRole/$1');

$routes->get('usuarios', 'UsuarioController::index');
$routes->post('usuarios/store', 'UsuarioController::store');
$routes->post('usuarios/update/(:num)', 'UsuarioController::update/$1');
$routes->post('usuarios/delete/(:num)', 'UsuarioController::delete/$1');
$routes->get('usuarios/getUsuario/(:num)', 'UsuarioController::getUsuario/$1');
$routes->post('usuarios/cambiarPassword', 'UsuarioController::cambiarPassword');

$routes->get('equipos', 'EquiposController::index');
$routes->get('equipos/getUnidadesEducativas', 'EquiposController::getUnidadesEducativas');
$routes->post('equipos/guardar', 'EquiposController::guardar');



$routes->get('equipo/buscarUnidadEducativa', 'EquipoController::buscarUnidadEducativa');
$routes->post('equipo/registrarEquipo', 'EquipoController::registrarEquipo');
