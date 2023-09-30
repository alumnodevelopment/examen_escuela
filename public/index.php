<?php 
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\AppController;
use Controllers\GradoController;
use Controllers\AlumnoController;
use Controllers\AsistenciaController;
use Controllers\ProfesorController;
use Controllers\SeccionController;
use Controllers\TutorController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);


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

//asistencia
$router->get('/asistencia', [AsistenciaController::class,'index']);
$router->post('/API/asistencia/guardar', [AsistenciaController::class,'guardarAPI'] );
$router->post('/API/asistencia/modificar', [AsistenciaController::class,'modificarAPI'] );
$router->post('/API/asistencia/eliminar', [AsistenciaController::class,'eliminarAPI'] );
$router->get('/API/asistencia/buscar', [AsistenciaController::class,'buscarAPI'] );
$router->get('/API/asistencia/buscarGrado', [AsistenciaController::class, 'buscarGradoAPI']);
$router->get('/API/asistencia/buscarSeccion', [AsistenciaController::class, 'buscarSeccionAPI']);
$router->get('/API/asistencia/buscarAlumnos', [AsistenciaController::class, 'buscarAlumnosAPI']);




$router->get('/grados/datatable', [GradoController::class,'datatable']);
$router->post('/API/grados/guardar', [GradoController::class,'guardarAPI'] );
$router->post('/API/grados/modificar', [GradoController::class,'modificarAPI'] );
$router->post('/API/grados/eliminar', [GradoController::class,'eliminarAPI'] );
$router->get('/API/grados/buscar', [GradoController::class,'buscarAPI'] );
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
