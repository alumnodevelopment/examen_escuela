<?php

namespace Model;

class Profesor extends ActiveRecord
{
    protected static $tabla = 'profesores';
    protected static $columnasDB = ['profesor_nombre', 'profesor_telefono', 'profesor_situacion'];
    protected static $idTabla = 'profesor_id';

    public $profesor_id;
    public $profesor_nombre;
    public $profesor_telefono;
    public $profesor_situacion;

    public function __construct($args = [])
    {
        $this->profesor_id = $args['profesor_id'] ?? null;
        $this->profesor_nombre = $args['profesor_nombre'] ?? '';
        $this->profesor_telefono = $args['profesor_telefono'] ?? '';
        $this->profesor_situacion = $args['profesor_situacion'] ?? '1';
    }
}
