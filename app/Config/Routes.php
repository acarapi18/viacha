<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('admin', 'DashboardController::admin', ['as' => 'dashboard.admin']);
    $routes->get('tecnico', 'DashboardController::tecnico', ['as' => 'dashboard.tecnico']);
    $routes->get('encargado', 'DashboardController::encargado', ['as' => 'dashboard.encargado']);
});


$routes->get('unidad_educativa', 'UnidadEducativaController::index');
$routes->post('unidad_educativa/store', 'UnidadEducativaController::store');
$routes->post('unidad_educativa/update/(:num)', 'UnidadEducativaController::update/$1');
$routes->post('unidad_educativa/delete/(:num)', 'UnidadEducativaController::delete/$1');
$routes->get('unidad_educativa/getUnidadEducativa/(:num)', 'UnidadEducativaController::getUnidadEducativa/$1');
$routes->post('unidad_educativa/obtenerDatos', 'UnidadEducativaController::obtenerDatos');
$routes->get('unidad_educativa/pdf/(:num)', 'UnidadEducativaController::generatePDF/$1');


$routes->get('login', 'LoginController::index');
$routes->post('authenticate', 'LoginController::authenticate');
$routes->get('logout', 'LoginController::logout');

$routes->get('usuarios', 'UsuarioController::index');
$routes->post('usuarios/store', 'UsuarioController::store');
$routes->post('usuarios/update/(:num)', 'UsuarioController::update/$1');
$routes->post('usuarios/delete/(:num)', 'UsuarioController::delete/$1');
$routes->get('usuarios/getUsuario/(:num)', 'UsuarioController::getUsuario/$1');
$routes->post('usuarios/cambiarPassword', 'UsuarioController::cambiarPassword');

$routes->get('equipos', 'EquiposController::index'); // Ruta para listar los equipos
$routes->post('equipos/store', 'EquiposController::store'); // Ruta para guardar un nuevo equipo
$routes->post('equipos/update/(:num)', 'EquiposController::update/$1'); // Ruta para actualizar un equipo
$routes->post('equipos/delete/(:num)', 'EquiposController::delete/$1'); // Ruta para eliminar un equipo
$routes->get('equipos/getEquipos/(:num)', 'EquiposController::getEquipos/$1');

// Rutas para MantenimientoController
$routes->get('mantenimiento', 'MantenimientoController::index'); // Página principal de mantenimiento
$routes->get('mantenimiento/listarEquiposReportados', 'MantenimientoController::listarEquiposReportados'); // Listar equipos reportados
$routes->get('mantenimiento/buscarPorSerie', 'MantenimientoController::buscarPorSerie'); // Buscar equipo por serie
$routes->get('mantenimiento/obtener-equipo', 'MantenimientoController::obtenerEquipo'); // Obtener equipo por ID
$routes->post('mantenimiento/registrarMantenimiento', 'MantenimientoController::registrarMantenimiento'); // Registrar mantenimiento
$routes->post('mantenimiento/actualizar-estado', 'MantenimientoController::actualizarEstado'); // Actualizar estado de mantenimiento
$routes->post('mantenimiento/eliminarEquipo', 'MantenimientoController::eliminarEquipo');


$routes->get('inventario', 'InventarioController::index');
$routes->get('inventario/listarEquiposInventariados', 'InventarioController::listarEquiposInventariados');
$routes->get('inventario/buscarPorSerie', 'InventarioController::buscarPorSerie');
$routes->get('inventario/obtenerEquipo', 'InventarioController::obtenerEquipo');
$routes->post('inventario/modificarEquipo', 'InventarioController::modificarEquipo');
$routes->post('inventario/eliminarEquipo', 'InventarioController::eliminarEquipo');




$routes->get('asignacion', 'AsignacionController::index'); // Ruta para mostrar la vista principal
$routes->get('asignacion/obtenerPendientes', 'AsignacionController::obtenerPendientes'); // Ruta para obtener los mantenimientos pendientes
$routes->get('asignacion/obtenerTecnicos', 'AsignacionController::obtenerTecnicos'); // Obtener técnicos
$routes->post('asignacion/asignarTecnico', 'AsignacionController::asignarTecnico'); // Asignar un técnico

$routes->get('soporte', 'SoporteController::index');
$routes->get('soporte/getByUnidad/(:num)', 'SoporteController::getByUnidad/$1');
$routes->get('soporte/getById/(:num)', 'SoporteController::getById/$1');
$routes->post('soporte/update', 'SoporteController::update');


