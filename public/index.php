<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\GradoController;
use Controllers\SeccionController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);


$router->get('/grados/datatable', [GradoController::class,'datatable']);
$router->post('/API/grados/guardar', [GradoController::class,'guardarAPI'] );
$router->post('/API/grados/modificar', [GradoController::class,'modificarAPI'] );
$router->post('/API/grados/eliminar', [GradoController::class,'eliminarAPI'] );
$router->get('/API/grados/buscar', [GradoController::class,'buscarAPI'] );

$router->get('/secciones/datatable', [SeccionController::class,'datatable']);
$router->post('/API/secciones/guardar', [SeccionController::class,'guardarAPI'] );
$router->post('/API/secciones/modificar', [SeccionController::class,'modificarAPI'] );
$router->post('/API/secciones/eliminar', [SeccionController::class,'eliminarAPI'] );
$router->get('/API/secciones/buscar', [SeccionController::class,'buscarAPI'] );
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
