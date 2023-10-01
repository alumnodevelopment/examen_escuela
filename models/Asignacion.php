<?php
namespace Model;

class Asignacion extends ActiveRecord {
    public static $tabla = 'asignaciones';
    public static $columnasDB = ['asignacion_alumno', 'asignacion_profesor', 'asignacion_grado', 'asignacion_seccion', 'asignacion_situacion'
    ];
    public static $idTabla = 'asignacion_id';

    public $asignacion_id;
    public $asignacion_alumno;
    public $asignacion_profesor;
    public $asignacion_grado;
    public $asignacion_seccion;
    public $asignacion_situacion;

    public function __construct($args = []) {
        $this->asignacion_id = $args['asignacion_id'] ?? null;
        $this->asignacion_alumno = $args['asignacion_alumno'] ?? null;
        $this->asignacion_profesor = $args['asignacion_profesor'] ?? null;
        $this->asignacion_grado = $args['asignacion_grado'] ?? null;
        $this->asignacion_seccion = $args['asignacion_seccion'] ?? null;
        $this->asignacion_situacion = $args['asignacion_situacion'] ?? 1;
    }
}
?>