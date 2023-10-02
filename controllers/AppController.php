<?php

namespace Controllers;

use MVC\Router;

class AppController {
    public static function index(Router $router){
        if(!isset($_SESSION['tipo'])){
            $router->render('login/index', []);
        }else{
            $router->render('pages/index', []);
        }
    }

}