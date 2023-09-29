<?php

namespace Model;

class Alumno extends ActiveRecord{
    protected static $tabla = 'alumnos';
    protected static $columnasDB = ['alumno_nombre','alumno_edad','alumno_sexo','alumno_fecha_nacimiento','alumno_situacion'];
    protected static $idTabla = 'alumno_id';
    
    public $alumno_id;
    public $alumno_nombre;
    public $alumno_edad;
    public $alumno_sexo;
    public $alumno_fecha_nacimiento;
    public $alumno_situacion;

    public function __construct($args = [])
    {
        $this->alumno_id = $args['alumno_id'] ?? null;
        $this->alumno_nombre = $args['alumno_nombre'] ?? '';
        $this->alumno_edad = $args['alumno_edad'] ?? '';
        $this->alumno_sexo = $args['alumno_sexo'] ?? '';
        $this->alumno_fecha_nacimiento = $args['alumno_fecha_nacimiento'] ?? '';
        $this->alumno_situacion = $args['alumno_situacion'] ?? 1;
    }
}