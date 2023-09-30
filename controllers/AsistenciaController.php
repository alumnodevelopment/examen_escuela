<?php

namespace Controllers;

use Exception;
use Model\Profesor;
use Model\Tutor;
use Model\Alumno;
use Model\Asistencia;
use Model\Grado;
use Model\Seccion;
use MVC\Router;


class AsistenciaController {
    public static function index(Router $router)
    {
        $router->render('asistencia/index', []);
      
}




public static function guardarAPI() {
    try {
        $grado_id = $_POST["grado_id"];
        $seccion_id = $_POST["seccion_id"];
        $alumno_id = $_POST["alumno_id"];
        $asistencia_fecha = $_POST["asistencia_fecha"];
        $asistencia_asistio = $_POST["asistencia_asistio"];
        $asistencia_situacion = $_POST["asistencia_situacion"];

        // Crear un nuevo registro de asistencia utilizando el modelo Asistencia
        $asistencia = new Asistencia([
            'grado_id' => $grado_id,
            'seccion_id' => $seccion_id,
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

public static function modificarAPI() {
    try {
        $asistencia_id = $_POST['asistencia_id'];
        $grado_id = $_POST["grado_id"];
        $seccion_id = $_POST["seccion_id"];
        $alumno_id = $_POST["alumno_id"];
        $asistencia_fecha = $_POST["asistencia_fecha"];
        $asistencia_asistio = $_POST["asistencia_asistio"];
        $asistencia_situacion = $_POST["asistencia_situacion"];

        // Actualizar el registro de asistencia utilizando el modelo Asistencia
        $asistencia = new Asistencia([
            'asistencia_id' => $asistencia_id,
            'grado_id' => $grado_id,
            'seccion_id' => $seccion_id,
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

public static function eliminarAPI() {
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


public static function buscarAPI() {
    try {
        $grado_id = $_GET['grado_id'] ?? null;
        $seccion_id = $_GET['seccion_id'] ?? null;
        
        // Verificar si se proporcionaron tanto el grado como la sección
        if ($grado_id !== null && $seccion_id !== null) {
            // Construir y ejecutar la consulta SQL según los parámetros de búsqueda
            $sql = "SELECT * FROM asistencia WHERE grado_id = :grado_id AND seccion_id = :seccion_id";


            $asistencia = Asistencia::fetchArray($sql);
            echo json_encode($asistencia);

            // Devolver los resultados en formato JSON
            echo json_encode($asistencia);
        } else {
            // Si no se proporcionaron tanto grado como sección, retornar un mensaje de error
            echo json_encode([
                'mensaje' => 'Por favor, proporciona tanto el grado como la sección para buscar registros de asistencia.',
                'codigo' => 0
            ]);
        }
    } catch (Exception $e) {
        // Manejo de errores y respuesta en caso de excepción
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error al procesar la solicitud',
            'codigo' => 0
        ]);
    }
}


public static function buscarGrado(){
    $sql = "SELECT grado_nombre FROM grados WHERE grado_situacion = 1";

    try {
        // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
        $grados = Grado::fetchArray($sql);

    

        // Enviar la respuesta como un objeto JSON
        echo json_encode($grados);
    } catch (Exception $e) {
        // En caso de error, enviar un JSON con información del error
        // header('Content-Type: application/json');
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function buscarSeccion(){
    $sql = "SELECT seccion_nombre FROM secciones WHERE seccion_situacion = 1";

    try {
        // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
        $seccion = Seccion::fetchArray($sql);

    

        // Enviar la respuesta como un objeto JSON
        echo json_encode($seccion);
    } catch (Exception $e) {
        // En caso de error, enviar un JSON con información del error
        // header('Content-Type: application/json');
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}



}