<?php

namespace Controllers;

use Exception;
use Model\Profesor;
use Model\Tutor;
use Model\Alumno;
use Model\Asignacion;
use Model\Asistencia;
use Model\Grado;
use Model\Seccion;
use MVC\Router;


class AsistenciaController
{
    public static function index(Router $router)
    {
        $router->render('asistencia/index', []);
    }




    public static function guardarAPI()
    {
        try {
            $alumno_id = $_POST["alumno_id"];
            $asistencia_fecha = $_POST["asistencia_fecha"];
            $asistencia_asistio = $_POST["asistencia_asistio"];
            $asistencia_situacion = $_POST["asistencia_situacion"];

            // Crear un nuevo registro de asistencia utilizando el modelo Asistencia
            $asistencia = new Asistencia([
                'alumno_id' => $alumno_id,
                'asistencia_fecha' => $asistencia_fecha,
                'asistencia_asistio' => $asistencia_asistio,
                'asistencia_situacion' => $asistencia_situacion
            ]);

            $resultado = $asistencia->crear();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de asistencia guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error al guardar la asistencia',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'codigo' => 0
            ]);
        }
    }

    public static function modificarAPI()
    {
        try {
            $asistencia_id = $_POST['asistencia_id'];
            $alumno_id = $_POST["alumno_id"];
            $asistencia_fecha = $_POST["asistencia_fecha"];
            $asistencia_asistio = $_POST["asistencia_asistio"];
            $asistencia_situacion = $_POST["asistencia_situacion"];

            $asistencia_fecha = date('Y-m-d', strtotime($asistencia_fecha));
            // Actualizar el registro de asistencia utilizando el modelo Asistencia
            $asistencia = new Asistencia([
                'asistencia_id' => $asistencia_id,
                'alumno_id' => $alumno_id,
                'asistencia_fecha' => $asistencia_fecha,
                'asistencia_asistio' => $asistencia_asistio,
                'asistencia_situacion' => $asistencia_situacion
            ]);

            $resultado = $asistencia->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de asistencia modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'No se encontraron registros de asistencia para actualizar',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'codigo' => 0
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $asistencia_id = $_POST['asistencia_id'];

            // Utilizar el modelo Asistencia para eliminar el registro correspondiente
            $asistencia = Asistencia::find($asistencia_id);
            $asistencia->asistencia_situacion = 0;
            $resultado = $asistencia->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Se ha eliminado el registro de asistencia con éxito',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'El registro de asistencia no pudo ser eliminado. Intente nuevamente o contacte al administrador del sistema',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'codigo' => 0
            ]);
        }
    }


    public static function buscarAPI(){
        $alumnoId = $_GET['alumno_id'] ?? '';
        $fecha = $_GET['asistencia_fecha'] ?? '';
    
        $sql = "SELECT a.asistencia_id, 
        al.alumno_nombre as alumno_id, 
        a.asistencia_fecha, 
        a.asistencia_asistio, 
        a.asistencia_situacion 
 FROM asistencia a
 JOIN alumnos al ON a.alumno_id = al.alumno_id
 WHERE a.asistencia_situacion = 1";
    
        if ($alumnoId != '') {
            $sql .= " AND a.alumno_id = $alumnoId";
        }
    
        if ($fecha != '') {
            // Convertir la fecha en el formato que tienes en la base de datos, por ejemplo, 'Y-m-d'
            // Dependiendo del formato de tu base de datos
            //$fecha = date('Y-m-d', strtotime($fecha));
            $sql .= " AND a.asistencia_fecha = '$fecha'";
        }
    
        try {
            $asistencias = Asistencia::fetchArray($sql);
            echo json_encode($asistencias);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    


    public static function buscarGradoAPI()
    {
        $sql = "SELECT grado_id, grado_nombre FROM grados WHERE grado_situacion = 1";

        try {
            // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
            $grados = Grado::fetchArray($sql);



            // Enviar la respuesta como un objeto JSON
            echo json_encode($grados);

            //echo json_encode(['grados' => $grados]);
        } catch (Exception $e) {
            // En caso de error, enviar un JSON con información del error
            header('Content-Type: application/json');
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function buscarSeccionAPI()
    {
        $sql = "SELECT seccion_id, seccion_nombre FROM secciones WHERE seccion_situacion = 1";

        try {
            // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
            $seccion = Seccion::fetchArray($sql);



            // Enviar la respuesta como un objeto JSON
            echo json_encode($seccion);

            //echo json_encode(['seccion' => $seccion]);
        } catch (Exception $e) {
            // En caso de error, enviar un JSON con información del error
            header('Content-Type: application/json');
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function buscarAlumnoAPI(){
        $sql = "SELECT alumno_id, alumno_nombre FROM alumnos WHERE alumno_situacion = 1";
    
        try {
            // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
            $alumnos = Alumno::fetchArray($sql);
    
            // Enviar la respuesta como un objeto JSON
            echo json_encode($alumnos);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function buscarGradosSeccionesAPI()
    {


        try {
            $grado_id = $_GET['grado_id'] ?? '';
            $seccion_id = $_GET['seccion_id'] ?? '';

            // Verificar si se proporcionaron tanto el grado como la sección
            if ($grado_id !== '' && $seccion_id !== '') {

                // $sql = "SELECT grados.grado_nombre, secciones.seccion_nombre, alumnos.alumno_nombre
                // FROM asignacion_grados
                // JOIN alumnos ON asignacion_grados.alumno_id = alumnos.alumno_id
                // JOIN grados ON asignacion_grados.grado_id = grados.grado_id
                // JOIN secciones ON asignacion_grados.seccion_id = secciones.seccion_id;
                // ";


                $sql = "SELECT grados.grado_nombre, secciones.seccion_nombre, alumnos.alumno_nombre, alumnos.alumno_id
                FROM asignacion_grados
                JOIN alumnos ON asignacion_grados.alumno_id = alumnos.alumno_id
                JOIN grados ON asignacion_grados.grado_id = grados.grado_id
                JOIN secciones ON asignacion_grados.seccion_id = secciones.seccion_id
                WHERE grados.grado_id = $grado_id 
                AND secciones.seccion_id = $seccion_id 
                AND grados.grado_situacion = 1 
                AND secciones.seccion_situacion = 1 
                AND alumnos.alumno_situacion = 1;
                ";


                $resultado = Asignacion::fetchArray($sql);

                echo json_encode($resultado);
            } else {
                // Si no se proporcionaron tanto grado como sección, retornar un mensaje de error
                echo json_encode([
                    'mensaje' => 'Por favor, proporciona tanto el grado como la sección para buscar registros de asistencia.',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            // En caso de error, enviar un JSON con información del error
            header('Content-Type: application/json');
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}
