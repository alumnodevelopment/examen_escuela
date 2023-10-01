<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\GradoController;
use Controllers\ActividadController;
use Controllers\AlumnoController;
use Controllers\AsistenciaController;
use Controllers\ProfesorController;
use Controllers\PagoController;


$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/alumnos', [AlumnoController::class, 'index']);
$router->get('/API/alumnos/buscar', [AlumnoController::class, 'buscarAPI']);
$router->post('/API/alumnos/guardar', [AlumnoController::class, 'guardarAPI']);
$router->post('/API/alumnos/modificar', [AlumnoController::class, 'modificarAPI']);
$router->post('/API/alumnos/eliminar', [AlumnoController::class, 'eliminarAPI']);


$router->get('/alumnos', [AlumnoController::class, 'index']);
$router->get('/API/alumnos/buscar', [AlumnoController::class, 'buscarAPI']);
$router->post('/API/alumnos/guardar', [AlumnoController::class, 'guardarAPI']);
$router->post('/API/alumnos/modificar', [AlumnoController::class, 'modificarAPI']);
$router->post('/API/alumnos/eliminar', [AlumnoController::class, 'eliminarAPI']);

//tutores
$router->get('/tutores', [TutorController::class,'index']);
$router->post('/API/tutores/guardar', [TutorController::class,'guardarAPI'] );
$router->post('/API/tutores/modificar', [TutorController::class,'modificarAPI'] );
$router->post('/API/tutores/eliminar', [TutorController::class,'eliminarAPI'] );
$router->get('/API/tutores/buscar', [TutorController::class,'buscarAPI'] );
$router->get('/API/tutores/buscarAlumno', [TutorController::class, 'buscarAlumnoAPI']);


//profesores
$router->get('/profesores', [ProfesorController::class,'index']);
$router->post('/API/profesores/guardar', [ProfesorController::class,'guardarAPI'] );
$router->post('/API/profesores/modificar', [ProfesorController::class,'modificarAPI'] );
$router->post('/API/profesores/eliminar', [ProfesorController::class,'eliminarAPI'] );
$router->get('/API/profesores/buscar', [ProfesorController::class,'buscarAPI'] );



$router->get('/pagos', [PagoController::class, 'index']);
$router->get('/API/pagos/buscar', [PagoController::class, 'buscarAPI']);
$router->post('/API/pagos/guardar', [PagoController::class, 'guardarAPI']);
$router->post('/API/pagos/modificar', [PagoController::class, 'modificarAPI']);
$router->post('/API/pagos/eliminar', [PagoController::class, 'eliminarAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
///examen_esc/API/reportePagos/generar