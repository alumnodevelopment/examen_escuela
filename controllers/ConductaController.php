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

        $alumno_id = $_GET['alumno_id'] ?? '';
        $conducta_fecha = $_GET['conducta_fecha'] ?? '';


        $sql = "SELECT c.conducta_id, a.alumno_nombre, c.conducta_fecha, c.conducta_descripcion
        FROM conducta c
        INNER JOIN alumnos a ON a.alumno_id = c.alumno_id
        WHERE c.conducta_situacion = 1;";

        if ($alumno_id != '') {
            $sql .= " AND a.alumno_id LIKE '%${alumno_id}%'";
        }

        if ($conducta_fecha != '') {
            $sql .= " AND c.conducta_fecha LIKE '%${conducta_fecha}%'";
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