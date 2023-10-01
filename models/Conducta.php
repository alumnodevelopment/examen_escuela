<?php

namespace Model;

class Conducta extends ActiveRecord {
    protected static $tabla = 'conducta';
    protected static $columnasDB = ['alumno_id', 'conducta_fecha', 'conducta_descripcion', 'conducta_situacion'];
    protected static $idTabla = 'conducta_id';
    
    public $conducta_id;
    public $alumno_id;
    public $conducta_fecha;
    public $conducta_descripcion;
    public $conducta_situacion;

    public function __construct($args = []) {
        $this->conducta_id = $args['conducta_id'] ?? null;
        $this->alumno_id = $args['alumno_id'] ?? '';
        $this->conducta_fecha = $args['conducta_fecha'] ?? '';
        $this->conducta_descripcion = $args['conducta_descripcion'] ?? '';
        $this->conducta_situacion = $args['conducta_situacion'] ?? 1;
    }
}