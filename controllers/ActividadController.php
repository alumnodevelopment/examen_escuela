<?php

namespace Controllers;

use Exception;
use Model\Grado;
use Model\Seccion;
use Model\Profesor;
use Model\Actividad;
use MVC\Router;

class AsignacionController{

    public static function index(Router $router){
        $grados = static::buscarGrado();
        $secciones = static::buscarSeccion();
        $profesores = static::buscarProfesor();
        $actividades = Actividad::all();
    
        $router->render('actividades/index', [
            'grados' => $grados,
            'secciones' => $secciones,
            'profesores' => $profesores,
            'actividades' => $actividades,
        ]);
    }

public static function buscarGrado(){
    $sql = "SELECT * FROM grados where grado_situacion = 1";

    try{
        $grados = Grado::fetchArray($sql);
        return $grados; 
    } catch (Exception $e){
        return []; 
    }
}

public static function buscarSeccion(){
    $sql = "SELECT * FROM secciones where seccion_situacion = 1";

    try{
        $secciones = Seccion::fetchArray($sql);
        return $secciones; 
    } catch (Exception $e){
        return []; 
    }
}

public static function buscarProfesor(){
    $sql = "SELECT * FROM profesores where profesor_situacion = 1";

    try{
        $profesores = Profesor::fetchArray($sql);
        return $profesores; 
    } catch (Exception $e){
        return []; 
    }
}

    public static function guardarAPI()
    {
      
        try {
            $actividad = new Actividad($_POST);
            $resultado = $actividad->crear();

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
            $actividad = new Actividad($_POST);
            
            $resultado = $actividad->actualizar();

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
            $actividad_id = $_POST['actividad_id'];
            $actividad = Actividad::find($actividad_id);
            $actividad->actividad_situacion = 0;
            $resultado = $actividad->actualizar();

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
    $profesor_id = $_GET['profesor_id'];
    $grado_id = $_GET['grado_id'];
    $seccion_id = $_GET['seccion_id'];

    $sql = "SELECT 
    a.actividad_id, 
    p.profesor_nombre AS actividad_profesor,
    p.profesor_id,
    g.grado_nombre AS actividad_grado,
    g.grado_id,
    s.seccion_nombre AS actividad_seccion,
    s.seccion_id,
    a.actividad_fecha_inicio AS fecha_inicio,
    a.actividad_fecha_fin AS fecha_fin,
    a.actividad_descripcion AS actividad
FROM 
    actividades a
INNER JOIN 
    profesores p ON a.actividad_profesor = p.profesor_id
INNER JOIN 
    grados g ON a.actividad_grado = g.grado_id
INNER JOIN 
    secciones s ON a.actividad_seccion = s.seccion_id
WHERE
    a.actividad_situacion = 1";

    if ($profesor_id != '') {
        $sql .= " AND a.actividad_profesor = '$profesor_id' ";
    }

    if ($grado_id != '') {
        $sql .= " AND a.actividad_grado = '$grado_id' ";
    }

    if ($seccion_id != '') {
        $sql .= " AND a.actividad_seccion = '$seccion_id' ";
    }

    try {
        $actividades = Actividad::fetchArray($sql);

        echo json_encode($actividades);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0
        ]);
    }
}

    



}




