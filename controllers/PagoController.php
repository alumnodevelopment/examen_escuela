<?php

namespace Controllers;

use Exception;
use Model\Pago;
use Model\Alumno;
use MVC\Router;

class PagoController {
    public static function index(Router $router) {

        $alumnos = static::BuscarAlumnos();
        
        // $pagos = Pago::all();

        $router->render('pagos/index', [
            'alumnos' => $alumnos,
        ]);
    }

    public static function guardarAPI() {
        try {
            $pagoData = $_POST;

            // Formatea la fecha al formato 'YYYY-MM-DD' antes de guardarla
            $pagoData['pago_fecha'] = date('Y-m-d', strtotime($pagoData['pago_fecha']));

            $pago = new Pago($pagoData);
            $resultado = $pago->guardar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de pago guardado correctamente',
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
        $pago_fecha = $_GET['pago_fecha'] ?? '';

        $sql = "SELECT p.pago_id, a.alumno_nombre, p.pago_fecha, p.pago_mes, p.pago_monto, p.pago_solvencia
        FROM pagos p
        INNER JOIN alumnos a ON a.alumno_id = p.pago_alumno_id
        WHERE p.pago_situacion = 1;";

        if ($alumno_id != '') {
            $sql .= " AND a.alumno_id LIKE '%${alumno_id}%'";
        }

        if ($pago_fecha != '') {
            $sql .= " AND p.pago_fecha LIKE '%${pago_fecha}%'";
        }

        try {
            $pagos = Pago::fetchArray($sql);
            echo json_encode($pagos);
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
            $alumnos = Alumno::fetchArray($sql);
            return $alumnos;
        } catch (Exception $e) {
    
        }
        
    }
    
    public static function modificarAPI() {
        try {
            $pago = new Pago($_POST);
            $resultado = $pago->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de pago modificado correctamente',
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
            $pago_id = $_POST['pago_id'];
            $pago = Pago::find($pago_id);
            $pago->pago_situacion = 0;
            $resultado = $pago->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro de pago eliminado correctamente',
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