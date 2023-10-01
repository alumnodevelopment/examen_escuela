<?php

namespace Model;

class Actividad extends ActiveRecord {
    protected static $tabla = 'actividades'; 
    protected static $columnasDB = ['profesor_id', 'fecha_inicio', 'fecha_fin', 'actividad_descripcion', 'actividad_situacion'];
    protected static $idTabla = 'actividad_id';

    public $actividad_id;
    public $profesor_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $actividad_descripcion;
    public $actividad_situacion;

    public function __construct($args = []) {
        $this->actividad_id = $args['actividad_id'] ?? null;
        $this->profesor_id = $args['profesor_id'] ?? '';
        $this->fecha_inicio = $args['fecha_inicio'] ?? '';
        $this->fecha_fin = $args['fecha_fin'] ?? '';
        $this->actividad_descripcion = $args['actividad_descripcion'] ?? '';
        $this->actividad_situacion = $args['actividad_situacion'] ?? 1;
    }
}
