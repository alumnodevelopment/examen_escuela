<?php
namespace Controllers;

use Exception;
use Model\Alumno;
use Model\Grado;
use Model\Seccion;
use Model\Profesor;
use Model\Asignacion;
use MVC\Router;

class AsignacionController{

    public static function index(Router $router){
        $alumnos = static::buscarAlumno();
        $grados = static::buscarGrado();
        $secciones = static::buscarSeccion();
        $profesores = static::buscarProfesor();
        $asignaciones = Asignacion::all();
    
        $router->render('asignaciones/index', [
            'alumnos' => $alumnos,
            'grados' => $grados,
            'secciones' => $secciones,
            'profesores' => $profesores,
            'asignaciones' => $asignaciones,
        ]);
    }

public static function buscarAlumno(){
    $sql = "SELECT * FROM alumnos where alumno_situacion = 1";

    try{
        $alumnos = Alumno::fetchArray($sql);
        return $alumnos; 
    } catch (Exception $e){
        return []; 
    }
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
            $asignacion = new Asignacion($_POST);
            $resultado = $asignacion->crear();

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
            $asignacion = new Asignacion($_POST);
            
            $resultado = $asignacion->actualizar();

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
            $asignacion_id = $_POST['asignacion_id'];
            $asignacion = Asignacion::find($asignacion_id);
            $asignacion->asignacion_situacion = 0;
            $resultado = $asignacion->actualizar();

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
        $alumno_id = $_GET['alumno_id'];
        $profesor_id = $_GET['profesor_id'];
        $grado_id = $_GET['grado_id'];
        $seccion_id = $_GET['seccion_id'];
    
        $sql = "SELECT 
                    a.asignacion_id, 
                    al.alumno_nombre AS asignacion_alumno,
                    al.alumno_id, 
                    p.profesor_nombre AS asignacion_profesor,
                    p.profesor_id,
                    g.grado_nombre AS asignacion_grado,
                    g.grado_id,
                    s.seccion_nombre AS asignacion_seccion,
                    s.seccion_id
                FROM 
                    asignaciones a
                INNER JOIN 
                    alumnos al ON a.asignacion_alumno = al.alumno_id
                INNER JOIN 
                    profesores p ON a.asignacion_profesor = p.profesor_id
                INNER JOIN 
                    grados g ON a.asignacion_grado = g.grado_id
                INNER JOIN 
                    secciones s ON a.asignacion_seccion = s.seccion_id
                WHERE
                    a.asignacion_situacion = 1";
    
        if ($alumno_id != '') {
            $sql .= " AND asignaciones.asignacion_alumno = '$alumno_id'";
        }
    
        if ($profesor_id != '') {
            $sql .= " AND asignaciones.asignacion_profesor = '$profesor_id'";
        }
    
        if ($grado_id != '') {
            $sql .= " AND asignaciones.asignacion_grado = '$grado_id'";
        }
    
        if ($seccion_id != '') {
            $sql .= " AND asignaciones.asignacion_seccion = '$seccion_id'";
        }
    
        try {
            $asignaciones = Asignacion::fetchArray($sql);
    
            echo json_encode($asignaciones);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    



}