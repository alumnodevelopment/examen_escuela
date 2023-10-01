<?php

namespace Model;

class Pago extends ActiveRecord{
    protected static $tabla = 'pagos';
    protected static $columnasDB = ['pago_alumno_id', 'pago_fecha', 'pago_mes', 'pago_monto', 'pago_solvencia', 'pago_situacion'];
    protected static $idTabla = 'pago_id';
    
    public $pago_id;
    public $pago_alumno_id;
    public $pago_fecha;
    public $pago_mes;
    public $pago_monto;
    public $pago_solvencia;
    public $pago_situacion;

    public function __construct($args = []){
        
        $this->pago_id = $args['pago_id'] ?? null;
        $this->pago_alumno_id = $args['pago_alumno_id'] ?? '';
        $this->pago_fecha = $args['pago_fecha'] ?? '';
        $this->pago_mes = $args['pago_mes'] ?? '';
        $this->pago_monto = $args['pago_monto'] ?? '';
        $this->pago_solvencia = $args['pago_solvencia'] ?? '';
        $this->pago_situacion = $args['pago_situacion'] ?? 1;
    }
}