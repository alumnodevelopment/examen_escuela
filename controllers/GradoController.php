<?php

namespace Controllers;

use Exception;
use Model\Grado;
use MVC\Router;

class GradoController
{
    public static function datatable(Router $router){
        if(isset($_SESSION['auth_user'])){
        $router->render('grados/datatable', []);
    }else{
        header('Location: /examen_escuela/');
    }
    }

    public static function guardarAPI()
    {
        try {
            $grado = new Grado($_POST);
            $resultado = $grado->crear();

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
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function modificarAPI()
    {
        try {
            $grado = new Grado($_POST);
            $resultado = $grado->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro modificado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $grado_id = $_POST['grado_id'];
            $grado = Grado::find($grado_id);
            $grado->grado_situacion = 0;
            $resultado = $grado->actualizar();

            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro eliminado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
            // echo json_encode($resultado);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }

    
    public static function buscarAPI()
    {
        $grado_nombre = $_GET['grado_nombre'] ?? '';
     

        $sql = "SELECT * FROM grados WHERE grado_situacion = 1 ";
        if ($grado_nombre != '') {
            $grado_nombre = strtolower($grado_nombre);
            $sql .= " AND LOWER(grado_nombre) LIKE '%$grado_nombre%' ";
        }
        
        try {

            $grados = Grado::fetchArray($sql);

            echo json_encode($grados);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}
