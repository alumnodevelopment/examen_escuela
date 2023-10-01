<?php

namespace Model;

class grado extends ActiveRecord {
    public static $tabla = 'grados';
    public static $columnasDB = ['grado_nombre', 'grado_situacion'];
    public static $idTabla = 'grado_id';

    public $grado_id;
    public $grado_nombre;
    public $grado_situacion;

    public function __construct($args = []) {
        $this->grado_id = $args['grado_id'] ?? null;
        $this->grado_nombre = $args['grado_nombre'] ?? '';
        $this->grado_situacion = $args['grado_situacion'] ?? 1;
    }
}
