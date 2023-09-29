<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\AlumnoController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/alumnos', [AlumnoController::class, 'index']);
$router->get('/API/alumnos/buscar', [AlumnoController::class, 'buscarAPI']);
$router->post('/API/alumnos/guardar', [AlumnoController::class, 'guardarAPI']);
$router->post('/API/alumnos/modificar', [AlumnoController::class, 'modificarAPI']);
$router->post('/API/alumnos/eliminar', [AlumnoController::class, 'eliminarAPI']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
