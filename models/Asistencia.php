<?php

namespace Model;

class Asistencia extends ActiveRecord {
    protected static $tabla = 'asistencia';
    protected static $columnasDB = ['grado_id', 'seccion_id', 'alumno_id', 'asistencia_fecha', 'asistencia_asistio', 'asistencia_situacion'];
    protected static $idTabla = 'asistencia_id';
    
    public $asistencia_id;
    public $grado_id;
    public $seccion_id;
    public $alumno_id;
    public $asistencia_fecha;
    public $asistencia_asistio;
    public $asistencia_situacion;

    public function __construct($args = []) {
        $this->asistencia_id = $args['asistencia_id'] ?? null;
        $this->grado_id = $args['grado_id'] ?? '';
        $this->seccion_id = $args['seccion_id'] ?? '';
        $this->alumno_id = $args['alumno_id'] ?? '';
        $this->asistencia_fecha = $args['asistencia_fecha'] ?? '';
        $this->asistencia_asistio = $args['asistencia_asistio'] ?? '';
        $this->asistencia_situacion = $args['asistencia_situacion'] ?? 1;
    }
}
