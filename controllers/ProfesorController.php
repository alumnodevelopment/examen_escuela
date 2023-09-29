<?php

namespace Controllers;

use Exception;
use Model\Profesor;
use MVC\Router;


class ProfesorController {
    public static function index(Router $router)
    {
        $router->render('profesores/index', []);
      
}

}
