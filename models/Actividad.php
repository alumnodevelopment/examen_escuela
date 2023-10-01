<?php

namespace Model;

class Actividad extends ActiveRecord {
    protected static $tabla = 'actividades'; 
    protected static $columnasDB = ['actividad_profesor', 'actividad_grado', 'actividad_seccion', 'actividad_fecha_inicio', 'actividad_fecha_fin', 'actividad_descripcion', 'actividad_situacion'];
    protected static $idTabla = 'actividad_id';

    public $actividad_id;
    public $actividad_profesor;
    public $actividad_grado;
    public $actividad_seccion;
    public $actividad_fecha_inicio;
    public $actividad_fecha_fin;
    public $actividad_descripcion;
    public $actividad_situacion;

    public function __construct($args = []) {
        $this->actividad_id = $args['actividad_id'] ?? null;
        $this->actividad_profesor = $args['actividad_profesor'] ?? '';
        $this->actividad_grado = $args['actividad_grado'] ?? '';
        $this->actividad_seccion = $args['actividad_seccion'] ?? '';
        $this->actividad_fecha_inicio = $args['actividad_fecha_inicio'] ?? '';
        $this->actividad_fecha_fin = $args['actividad_fecha_fin'] ?? '';
        $this->actividad_descripcion = $args['actividad_descripcion'] ?? '';
        $this->actividad_situacion = $args['actividad_situacion'] ?? 1;
    }
}
