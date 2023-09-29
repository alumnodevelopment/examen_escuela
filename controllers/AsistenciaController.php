<?php

namespace Controllers;

use Exception;
use Model\Profesor;
use Model\Tutor;
use Model\Alumno;
use MVC\Router;


class AsistenciaController {
    public static function index(Router $router)
    {
        $router->render('asistencia/index', []);
      
}

}