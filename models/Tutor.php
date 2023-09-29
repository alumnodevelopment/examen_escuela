<?php

namespace Model;

class Tutor extends ActiveRecord
{
    protected static $tabla = 'tutores';
    protected static $columnasDB = ['tutor_nombre', 'tutor_telefono', 'tutor_parentezco', 'alumno_id', 'tutor_situacion'];
    protected static $idTabla = 'tutor_id';

    public $tutor_id;
    public $tutor_nombre;
    public $tutor_telefono;
    public $tutor_parentezco;
    public $alumno_id;
    public $tutor_situacion;

    public function __construct($args = [])
    {
        $this->tutor_id = $args['tutor_id'] ?? null;
        $this->tutor_nombre = $args['tutor_nombre'] ?? '';
        $this->tutor_telefono = $args['tutor_telefono'] ?? '';
        $this->tutor_parentezco = $args['tutor_parentezco'] ?? '';
        $this->alumno_id = $args['alumno_id'] ?? null;
        $this->tutor_situacion = $args['tutor_situacion'] ?? 1;
    }
}
