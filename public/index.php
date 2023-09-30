<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\GradoController;
use Controllers\AlumnoController;
use Controllers\ConductaController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$routealumnosr->get('/alumnos/', [AlumnoController::class,'datatable']);
$router->post('/API/alumnos/guardar', [AlumnoController::class,'guardarAPI'] );
$router->post('/API/alumnos/modificar', [AlumnoController::class,'modificarAPI'] );
$router->post('/API/alumnos/eliminar', [AlumnoController::class,'eliminarAPI'] );
$router->get('/API/alumnos/buscar', [AlumnoController::class,'buscarAPI'] );


$router->get('/grados/datatable', [GradoController::class,'datatable']);
$router->post('/API/grados/guardar', [GradoController::class,'guardarAPI'] );
$router->post('/API/grados/modificar', [GradoController::class,'modificarAPI'] );
$router->post('/API/grados/eliminar', [GradoController::class,'eliminarAPI'] );
$router->get('/API/grados/buscar', [GradoController::class,'buscarAPI'] );


$router->get('/conducta/', [ConductaController::class,'datatable']);
$router->post('/API/conducta/guardar', [ConductaController::class,'guardarAPI'] );
$router->post('/API/conducta/modificar', [ConductaController::class,'modificarAPI'] );
$router->post('/API/conducta/eliminar', [ConductaController::class,'eliminarAPI'] );
$router->get('/API/conducta/buscar', [ConductaController::class,'buscarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
