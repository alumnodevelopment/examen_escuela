<?php

namespace Model;

class Asistencia extends ActiveRecord{
    protected static $tabla = 'asistencia';
    protected static $columnasDB = ['alumno_id','asistencia_fecha','asistencia_asistio', 'asistencia_situacion'];
    protected static $idTabla = 'asistencia_id';
    
    public $asistencia_id;
    public $alumno_id;
    public $asistencia_fecha;
    public $asistencia_asistio;
    public $asistencia_situacion;

    public function __construct($args = [])
    {
        $this->asistencia_id = $args['asistencia_id'] ?? null;
        $this->alumno_id = $args['alumno_id'] ?? '';
        $this->asistencia_fecha = $args['asistencia_fecha'] ?? '';
        $this->asistencia_asistio = $args['asistencia_asistio'] ?? '';
        $this->asistencia_situacion = $args['asistencia_situacion'] ?? 1;
    }
}