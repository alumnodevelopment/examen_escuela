<?php

namespace Model;
class Seccion extends ActiveRecord {
    public static $tabla = 'secciones';
    public static $columnasDB = ['seccion_nombre', 'grado_id', 'seccion_situacion'];
    public static $idTabla = 'seccion_id';

    public $seccion_id;
    public $seccion_nombre;
    public $grado_id;
    public $seccion_situacion;

    public function __construct($args = []) {
        $this->seccion_id = $args['seccion_id'] ?? null;
        $this->seccion_nombre = $args['seccion_nombre'] ?? '';
        $this->grado_id = $args['grado_id'] ?? null;
        $this->seccion_situacion = $args['seccion_situacion'] ?? 1;
    }
}

?>