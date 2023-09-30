<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\GradoController;
use Controllers\SeccionController;
use Controllers\AsignacionController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/grados', [GradoController::class,'index'] );
$router->post('/API/grados/guardar', [GradoController::class,'guardarAPI'] );
$router->post('/API/grados/modificar', [GradoController::class,'modificarAPI'] );
$router->post('/API/grados/eliminar', [GradoController::class,'eliminarAPI'] );
$router->get('/API/grados/buscar', [GradoController::class,'buscarAPI'] );

$router->get('/secciones', [SeccionController::class,'index'] );
$router->post('/API/secciones/guardar', [SeccionController::class,'guardarAPI'] );
$router->post('/API/secciones/modificar', [SeccionController::class,'modificarAPI'] );
$router->post('/API/secciones/eliminar', [SeccionController::class,'eliminarAPI'] );
$router->get('/API/secciones/buscar', [SeccionController::class,'buscarAPI'] );

$router->get('/asignaciones', [AsignacionController::class,'index'] );
$router->post('/API/asignaciones/guardar', [AsignacionController::class,'guardarAPI'] );
$router->post('/API/asignaciones/modificar', [AsignacionController::class,'modificarAPI'] );
$router->post('/API/asignaciones/eliminar', [AsignacionController::class,'eliminarAPI'] );
$router->get('/API/asignaciones/buscar', [AsignacionController::class,'buscarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
