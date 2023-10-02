<?php

namespace Controllers;

use Exception;
use Model\Usuario;
use MVC\Router;

class UsuarioController {
    public static function login(Router $router){
        if(!isset($_SESSION['tipo'])){
            $router->render('login/index', []);
        }else{
            header('Location: /examen_escuela/');
        }
    }
    public static function registro(Router $router){
        if(!isset($_SESSION['tipo'])){
            $router->render('usuarios/index', []);
        }else{
            header('Location: /examen_escuela/');
        }
    }
    public static function loginAPI(){

        $usuario_name = $_POST['usuario_nombre'];
        $password = $_POST['usuario_password'];
        $usuarioRegistrado = Usuario::fetchFirst("SELECT * from usuarios where usuario_nombre = '${usuario_name}'
                                                    and usuario_password='${password}'");

        try {      
            if(is_array($usuarioRegistrado)){
                $nombre = $usuarioRegistrado['usuario_nombre'];
                $tipo_usuario=$usuarioRegistrado['usuario_tipo'];
                
                    session_start();
                    $_SESSION['tipo'] = $tipo_usuario;
                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => "Sesión iniciada correctamente. Bienvenido $tipo_usuario $nombre"
                    ]);
                
            }else{
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'Usuario no encontrado'
                ]);
    
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'codigo' => 0,
                'mensaje' => 'Usuario no encontrado'
            ]);
        }


    }


    public static function guardarAPI(){
        try {
            $nombre = $_POST["usuario_nombre"];
            $password = $_POST["usuario_password"];
            $tipo = $_POST["usuario_tipo"];


            if ($password) {

                $usuario = new Usuario([
                    'usuario_nombre' => $nombre,
                    'usuario_password' => $password,
                    'usuario_tipo' => $tipo,
                ]);

                $resultado = $usuario->crear();

                if ($resultado['resultado'] == 1) {
                    echo json_encode([
                        'mensaje' => 'usuario guardado correctamente',
                        'codigo' => 1
                    ]);
                } else {
                    echo json_encode([
                        'mensaje' => 'Ocurrió un error',
                        'codigo' => 0
                    ]);
                }
            } else {
                echo json_encode([
                    'mensaje' => 'Las contraseña no es correcta.',
                    'codigo' => 0
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }


    public static function logout(){
        $_SESSION = [];
        session_unset();
        session_destroy();
        header('Location: /examen_escuela/');
    }

}

