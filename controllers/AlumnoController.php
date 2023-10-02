<?php

namespace Controllers;

use Exception;
use Model\Alumno;
use MVC\Router;

class AlumnoController{
    public static function index(Router $router) {
    
        $alumnos = Alumno::all();        
       
        if(!isset($_SESSION['tipo'])){
            header('Location: /examen_escuela/');
            $router->render('login/index', []);
        }else{
            $router->render('alumnos/index', [
                'alumnos' => $alumnos,
            ]);
        }
    }

    public static function guardarAPI()
{
    try {
        $alumnoData = $_POST;

        // Formatea la fecha al formato 'YYYY-MM-DD' antes de guardarla
        $alumnoData['alumno_fecha_nacimiento'] = date('Y-m-d', strtotime($alumnoData['alumno_fecha_nacimiento']));

        $alumno = new Alumno($alumnoData);
        $resultado = $alumno->guardar();

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


    public static function buscarAPI(){

        $alumno_nombre = $_GET['alumno_nombre'] ?? '';
        $alumno_edad = $_GET['alumno_edad'] ?? '';
        $alumno_sexo = $_GET['alumno_sexo'] ?? '';
        $alumno_fecha_nacimiento = $_GET['alumno_fecha_nacimiento'] ?? '';


        $sql = "SELECT * FROM alumnos WHERE alumno_situacion = '1' ";

        if ($alumno_nombre != '') {
            $alumno_nombre = strtolower($alumno_nombre);
            $sql .= " AND LOWER(alumno_nombre) LIKE '%$alumno_nombre%' ";

            if ($alumno_edad != '') {
                $sql .= " AND alumno_edad LIKE '%$alumno_edad%'";
            }
    
            if ($alumno_sexo != '') {
                $sql .= " AND alumno_sexo LIKE '%$alumno_sexo%'";
            }
    
            if ($alumno_fecha_nacimiento != '') {
                $sql .= " AND alumno_fecha LIKE '%$alumno_fecha_nacimiento%'";
            }
        }

        try {

            $alumnos = Alumno::fetchArray($sql);

            echo json_encode($alumnos);
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
            $alumno = new Alumno($_POST);
            $resultado = $alumno->actualizar();
    
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

    public static function eliminarAPI(){

        try {
            $alumno_id = $_POST['alumno_id'];
            $alumno = Alumno::find($alumno_id);
            $alumno->alumno_situacion = 0;
            $resultado = $alumno->actualizar();
    
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
    }
   