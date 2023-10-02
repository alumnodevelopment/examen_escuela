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
use Controllers\SeccionController;
use Controllers\TutorController;
use Controllers\AsignacionController;
use Controllers\ReporteConductaController;
use Controllers\ReporteAsistenciaController;



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

$router->get('/grados', [GradoController::class,'index']);

//asistencia
$router->get('/asistencia', [AsistenciaController::class,'index']);
$router->post('/API/asistencia/guardar', [AsistenciaController::class,'guardarAPI'] );
$router->post('/API/asistencia/modificar', [AsistenciaController::class,'modificarAPI'] );
$router->post('/API/asistencia/eliminar', [AsistenciaController::class,'eliminarAPI'] );
$router->get('/API/asistencia/buscar', [AsistenciaController::class,'buscarAPI'] );
$router->get('/API/asistencia/buscarGrado', [AsistenciaController::class, 'buscarGradoAPI']);
$router->get('/API/asistencia/buscarSeccion', [AsistenciaController::class, 'buscarSeccionAPI']);
$router->get('/API/asistencia/buscarAlumno', [AsistenciaController::class, 'buscarAlumnoAPI']);
$router->get('/API/asistencia/buscarGradosSecciones', [AsistenciaController::class, 'buscarGradosSeccionesAPI']);


$router->get('/grados/datatable', [GradoController::class,'datatable']);

$router->post('/API/grados/guardar', [GradoController::class,'guardarAPI'] );
$router->post('/API/grados/modificar', [GradoController::class,'modificarAPI'] );
$router->post('/API/grados/eliminar', [GradoController::class,'eliminarAPI'] );
$router->get('/API/grados/buscar', [GradoController::class,'buscarAPI'] );

$router->get('/conductas', [ConductaController::class,'index']);
$router->post('/API/conductas/guardar', [ConductaController::class,'guardarAPI'] );
$router->post('/API/conductas/modificar', [ConductaController::class,'modificarAPI'] );
$router->post('/API/conductas/eliminar', [ConductaController::class,'eliminarAPI'] );
$router->get('/API/conductas/buscar', [ConductaController::class,'buscarAPI'] );

//pdf reporte conducta

$router->get('/pdfconductas', [ReporteConductaController::class,'index']);
$router->get('/API/pdfconductas/buscar', [ReporteConductaController::class,'buscarAPI'] );
$router->post('/ReporteConducta/generarPDF', [ReporteConductaController::class, 'generarPDF']);

$router->get('/pdfasistencias', [ReporteAsistenciaController::class,'index']);
$router->get('/API/pdfasistencias/buscar', [ReporteAsistenciaController::class,'pdf'] );
// $router->get('/reporteAsistencia/generarPDF', [ReporteAsistenciaController::class, 'pdf']);



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

$router->get('/actividades', [ActividadController::class,'index'] );
$router->post('/API/actividades/guardar', [ActividadController::class,'guardarAPI'] );
$router->post('/API/actividades/modificar', [ActividadController::class,'modificarAPI'] );
$router->post('/API/actividades/eliminar', [ActividadController::class,'eliminarAPI'] );
$router->get('/API/actividades/buscar', [ActividadController::class,'buscarAPI'] );


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
