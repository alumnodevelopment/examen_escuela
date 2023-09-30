<?php

namespace Controllers;

use Exception;
use Model\Conducta;
use Model\Alumno;
use MVC\Router;

class ConductaController {
    public static function index(Router $router) {

        $alumnos = static::BuscarAlumnos();
        
        // $conductas = Conducta::all();

        $router->render('conductas/index', [

            'alumnos' => $alumnos,
        ]);
    }

    public static function guardarAPI() {
        try {
            $conductaData = $_POST;

            // Formatea la fecha al formato 'YYYY-MM-DD' antes de guardarla
            $conductaData['conducta_fecha'] = date('Y-m-d', strtotime($conductaData['conducta_fecha']));

            $conducta = new Conducta($conductaData);
            $resultado = $conducta->guardar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de conducta guardado correctamente',
                    'codigo' => 1,
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0,
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0,
            ]);
        }
    }

    public static function buscarAPI() {

        $alumno_id = $_GET['alumno_id'];
        $conducta_fecha = $_GET['conducta_fecha'] ?? '';
        $conducta_descripcion = $_GET['conducta_descripcion'] ?? '';


        $sql = "SELECT * FROM conducta inner join alumnos on alumno_id = alumno_id WHERE conducta_situacion = 1 ";

        if ($alumno_id != '') {
            $sql .= " AND alumno_id LIKE '%$alumno_id%'";
        }

        if ($conducta_fecha != '') {
            $sql .= " AND conducta_fecha LIKE '%$conducta_fecha%'";
        }
        if ($conducta_descripcion != '') {
            $conducta_descripcion = strtolower($conducta_descripcion);
            $sql .= " AND LOWER(conducta_descripcion) LIKE '%$conducta_descripcion%' ";
        }

        try {
            $conductas = Conducta::fetchArray($sql);
            echo json_encode($conductas);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0,
            ]);
        }
    }

    public static function BuscarAlumnos(){

        $sql = "SELECT * FROM alumnos WHERE alumno_situacion = 1";
    
        try {
            $alumnos = Conducta::fetchArray($sql);
            return $alumnos;
        } catch (Exception $e) {
    
        }
        
    }
    
    public static function modificarAPI() {
        try {
            $conducta = new Conducta($_POST);
            $resultado = $conducta->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de conducta modificado correctamente',
                    'codigo' => 1,
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0,
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0,
            ]);
        }
    }

    public static function eliminarAPI() {
        try {
            $conducta_id = $_POST['conducta_id'];
            $conducta = Conducta::find($conducta_id);
            $conducta->conducta_situacion = 0;
            $resultado = $conducta->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de conducta eliminado correctamente',
                    'codigo' => 1,
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0,
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0,
            ]);
        }
    }
}