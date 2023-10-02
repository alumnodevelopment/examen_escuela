<?php

namespace Controllers;

use Exception;
use Model\Grado;
use Model\Seccion;
use Model\Profesor;
use Model\Actividad;
use MVC\Router;

class ActividadController{

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
        // Obtén los valores del formulario
        $actividad_profesor = $_POST['actividad_profesor'];
        $actividad_grado = $_POST['actividad_grado'];
        $actividad_seccion = $_POST['actividad_seccion'];
        $actividad_fecha_inicio = $_POST['actividad_fecha_inicio'];
        $actividad_fecha_fin = $_POST['actividad_fecha_fin'];
        $actividad_descripcion = $_POST['actividad_descripcion'];

        // Formatea las fechas en el formato adecuado (YYYY-MM-DD HH:MM)
        $fechaInicioFormateada = date('Y-m-d H:i', strtotime($actividad_fecha_inicio));
        $fechaFinFormateada = date('Y-m-d H:i', strtotime($actividad_fecha_fin));

        // Crea un nuevo objeto Actividad con los valores formateados
        $actividad = new Actividad([
            'actividad_profesor' => $actividad_profesor,
            'actividad_grado' => $actividad_grado,
            'actividad_seccion' => $actividad_seccion,
            'actividad_fecha_inicio' => $fechaInicioFormateada,
            'actividad_fecha_fin' => $fechaFinFormateada,
            'actividad_descripcion' => $actividad_descripcion,
        ]);

        // Llama al método crear() para guardar la actividad en la base de datos
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
        // Obtén los valores del formulario
        $actividad_profesor = $_POST['actividad_profesor'];
        $actividad_grado = $_POST['actividad_grado'];
        $actividad_seccion = $_POST['actividad_seccion'];
        $actividad_fecha_inicio = $_POST['actividad_fecha_inicio'];
        $actividad_fecha_fin = $_POST['actividad_fecha_fin'];
        $actividad_descripcion = $_POST['actividad_descripcion'];

        // Formatea las fechas en el formato adecuado (YYYY-MM-DD HH:MM)
        $fechaInicioFormateada = date('Y-m-d H:i', strtotime($actividad_fecha_inicio));
        $fechaFinFormateada = date('Y-m-d H:i', strtotime($actividad_fecha_fin));

        // Crea un nuevo objeto Actividad con los valores formateados
        $actividad = new Actividad([
            'actividad_id' => $_POST['actividad_id'], // Asegúrate de incluir el ID del registro que estás modificando
            'actividad_profesor' => $actividad_profesor,
            'actividad_grado' => $actividad_grado,
            'actividad_seccion' => $actividad_seccion,
            'actividad_fecha_inicio' => $fechaInicioFormateada,
            'actividad_fecha_fin' => $fechaFinFormateada,
            'actividad_descripcion' => $actividad_descripcion,
        ]);

        // Llama al método actualizar() para modificar la actividad en la base de datos
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
        p.profesor_nombre,
        g.grado_nombre, 
        s.seccion_nombre,
        a.actividad_fecha_fin,
        a.actividad_fecha_inicio ,
        a.actividad_descripcion 
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

    if (!empty($profesor_id)) {
        $profesor_id = strtolower($profesor_id);
        $sql .= " AND LOWER(p.profesor_nombre) LIKE '%$profesor_id%' ";
    }

    if (!empty($grado_id)) {
        $grado_id = strtolower($grado_id);
        $sql .= " AND LOWER(g.grado_nombre) LIKE '%$grado_id%' ";
    }

    if (!empty($seccion_id)) {
        $seccion_id = strtolower($seccion_id);
        $sql .= " AND LOWER(s.seccion_nombre) LIKE '%$seccion_id%' ";
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




