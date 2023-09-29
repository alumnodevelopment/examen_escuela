<?php

namespace Controllers;

use Exception;
use Model\Profesor;
use MVC\Router;


class ProfesorController {
    public static function index(Router $router)
    {
        $router->render('profesores/index', []);
      
}

public static function guardarAPI() {
    try {
        $nombre = $_POST["profesor_nombre"];
        $telefono = $_POST["profesor_telefono"];

        $profesor = new Profesor([
            'profesor_nombre' => $nombre,
            'profesor_telefono' => $telefono
        ]);

        $resultado = $profesor->crear();

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

public static function modificarAPI() {
    try {
        $profesorId = $_POST['profesor_id'];
        $nombre = $_POST["profesor_nombre"];
        $telefono = $_POST["profesor_telefono"];

        $profesor = new Profesor([
            'profesor_id' => $profesorId,
            'profesor_nombre' => $nombre,
            'profesor_telefono' => $telefono
        ]);

        $resultado = $profesor->actualizar();

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

public static function eliminarAPI() {
    try {
        $profesorId = $_POST['profesor_id'];
        $profesor = Profesor::find($profesorId);
        $resultado = $profesor->eliminar();

        if ($resultado['resultado'] == 1) {
            echo json_encode([
                'mensaje' => "Se ha eliminado el registro con éxito.",
                'codigo' => 1
            ]);
        } else {
            echo json_encode([
                'mensaje' => "El profesor no pudo ser borrado. Por favor intenta nuevamente o contacta al administrador del sistema.",
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

public static function buscarAPI() {
    $profesorNombre = $_GET['profesor_nombre'] ?? '';
    $sql = "SELECT * FROM profesores WHERE profesor_situacion = 1 ";
    if ($profesorNombre != '') {
        $profesorNombre = strtolower($profesorNombre);
        $sql .= " AND LOWER(profesor_nombre) LIKE '%$profesorNombre%' ";
    }

    try {
        $profesores = Profesor::fetchArray($sql);
        echo json_encode($profesores);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

}


