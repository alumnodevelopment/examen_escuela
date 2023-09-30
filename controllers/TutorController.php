<?php

namespace Controllers;

use Exception;
use Model\Tutor;
use Model\Alumno;
use MVC\Router;


class TutorController {
    public static function index(Router $router)
    {
        $router->render('tutores/index', []);
      
}


public static function guardarAPI(){
    try {
        $nombre = $_POST["tutor_nombre"];
        $telefono = $_POST["tutor_telefono"];
        $parentezco = $_POST["tutor_parentezco"];
        $alumnoId = $_POST["alumno_id"];

        $tutor = new Tutor([
            'tutor_nombre' => $nombre,
            'tutor_telefono' => $telefono,
            'tutor_parentezco' => $parentezco,
            'alumno_id' => $alumnoId
        ]);

        $resultado = $tutor->crear();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                'mensaje' => 'Registro guardado correctamente',
                'codigo' => 1
            ]);
        } else {
            echo json_encode([
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function modificarAPI(){
    try {
        $tutorId = $_POST['tutor_id'];
        $nombre = $_POST["tutor_nombre"];
        $telefono = $_POST["tutor_telefono"];
        $parentezco = $_POST["tutor_parentezco"];
        $alumnoId = $_POST["alumno_id"];

        $tutor = new Tutor([
            'tutor_id' => $tutorId,
            'tutor_nombre' => $nombre,
            'tutor_telefono' => $telefono,
            'tutor_parentezco' => $parentezco,
            'alumno_id' => $alumnoId
        ]);

        $resultado = $tutor->actualizar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                'mensaje' => 'Registro modificado correctamente',
                'codigo' => 1
            ]);
        } else {
            echo json_encode([
                'mensaje' => 'No se encontraron registros a actualizar',
                'codigo' => 0
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => "Error al realizar la operación",
            'codigo' => 0
        ]);
    }
}

public static function eliminarAPI(){
    try {
        $tutorId = $_POST['tutor_id'];
        $tutor = Tutor::find($tutorId);
        $tutor->tutor_situacion = 0;
        $resultado = $tutor->actualizar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                'mensaje' => "Se ha eliminado el registro con éxito.",
                'codigo' => 1
            ]);
        } else {
            echo json_encode([
                'mensaje' => "El tutor no pudo ser borrado. Por favor intenta nuevamente o contacta al administrador del sistema.",
                'codigo' => 0
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

public static function buscarAPI(){
    $tutorNombre = $_GET['tutor_nombre'] ?? '';
    $sql = "SELECT * FROM tutores WHERE tutor_situacion = 1 ";
    if ($tutorNombre != '') {
        $tutorNombre = strtolower($tutorNombre);
        $sql .= " AND LOWER(tutor_nombre) LIKE '%$tutorNombre%' ";
    }

    try {
        $tutores = Tutor::fetchArray($sql);
        echo json_encode($tutores);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}
// public static function buscarAlumno(){
//     $sql = "SELECT alumno_id, alumno_nombre FROM alumnos WHERE alumno_situacion = 1";

//     try {
//         // Realizar la consulta SQL y obtener los resultados (asumiendo que ya tienes la conexión)
//         $alumnos = Alumno::fetchArray($sql);

//         // Enviar la respuesta como un objeto JSON
//         echo json_encode($alumnos);
//     } catch (Exception $e) {
//         // En caso de error, enviar un JSON con información del error
//         // header('Content-Type: application/json');
//         echo json_encode([
//             'detalle' => $e->getMessage(),
//             'mensaje' => 'Ocurrió un error',
//             'codigo' => 0
//         ]);
//     }
// }

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


}

