<?php

namespace Controllers;

use Exception;
use Model\Seccion;
use MVC\Router;

class SeccionController
{
    public static function datatable(Router $router){
        if(isset($_SESSION['auth_user'])){
        $router->render('secciones/datatable', []);
    }else{
        header('Location: /examen_escuela/');
    }
    }

    public static function guardarAPI()
    {
        try {
            $seccion = new Seccion($_POST);
            $resultado = $seccion->crear();

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
            $seccion = new Seccion($_POST);
            $resultado = $seccion->actualizar();

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
            $seccion_id = $_POST['seccion_id'];
            $grado = Seccion::find($seccion_id);
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
    $seccion_nombre = $_GET['seccion_nombre'] ?? '';

    $sql = "SELECT * FROM secciones WHERE seccion_situacion = 1 ";
    if ($seccion_nombre != '') {
        $seccion_nombre = strtolower($seccion_nombre);
        $sql .= " AND LOWER(seccion_nombre) LIKE '%$seccion_nombre%' ";
    }

    try {
        $secciones = Seccion::fetchArray($sql);

        echo json_encode($secciones);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

}
