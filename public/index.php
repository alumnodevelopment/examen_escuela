<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\GradoController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);


$router->get('/grados/datatable', [GradoController::class,'datatable']);
$router->post('/API/grados/guardar', [GradoController::class,'guardarAPI'] );
$router->post('/API/grados/modificar', [GradoController::class,'modificarAPI'] );
$router->post('/API/grados/eliminar', [GradoController::class,'eliminarAPI'] );
$router->get('/API/grados/buscar', [GradoController::class,'buscarAPI'] );
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
