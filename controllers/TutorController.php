<?php

namespace Controllers;

use Exception;
use Model\Tutor;
use MVC\Router;


class TutorController {
    public static function index(Router $router)
    {
        $router->render('tutores/index', []);
      
}

}

