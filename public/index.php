<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\TutorController;
use Controllers\ProfesorController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

//tutores
$router->get('/tutores', [TutorController::class,'index']);
$router->post('/API/tutores/guardar', [TutorController::class,'guardarAPI'] );
$router->post('/API/tutores/modificar', [TutorController::class,'modificarAPI'] );
$router->post('/API/tutores/eliminar', [TutorController::class,'eliminarAPI'] );
$router->get('/API/tutores/buscar', [TutorController::class,'buscarAPI'] );


//profesores
$router->get('/profesores', [ProfesorController::class,'index']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
