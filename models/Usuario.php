<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['usuario_nombre','usuario_password', 'usuario_tipo','usuario_situacion'];
    protected static $idTabla = 'usuario_id';
    
    public $usuario_id;
    public $usuario_nombre;
    public $usuario_password;
    public $usuario_tipo;
    public $usuario_situacion;

    public function __construct($args = [])
    {
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->usuario_nombre = $args['usuario_nombre'] ?? '';
        $this->usuario_password = $args['usuario_password'] ?? '';
        $this->usuario_tipo = $args['usuario_tipo'] ?? '';
        $this->usuario_situacion = $args['usuario_situacion'] ?? '1';
    }
}