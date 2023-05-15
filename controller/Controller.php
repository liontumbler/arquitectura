<?php
require_once 'Redirecionar.php';
require_once '../db/Logger.php';
require_once '../db/Database.php';
require_once '../db/ConsultasDB.php';
require_once '../model/Model.php';

$variablesPeticion = file_get_contents('php://input');
$vars = json_decode($variablesPeticion);
$valores = count((array)$vars);
//print_r($valores);
if ($valores == 0) {
    header('Location: ../index');
}

class Controller
{
    protected $token;
    function __construct($token)
    {
        try {
            @\session_start();
            $this->token = $token;
        } catch (Exception $e) {
            echo 'Error: '.$e->getMessage();
            die();
        }
    }

    protected function model($modelo)
    {
        try {
            $pMayuscula = ucfirst($modelo);
            $ruta = '../model/'. $pMayuscula .'.php';

            if (is_file($ruta)) {
                require_once $ruta;
                return new $pMayuscula;
            } else {
                throw new Exception('File not found: '.$ruta);
            }
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    protected function view($view)
    {
        try {
            $ruta = '../view/'. $view .'.php';
            if (is_file($ruta)) {
                require_once $ruta;
                return new $view;
            } else {
                throw new Exception('File not found: '.$ruta);
            }
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    protected function validarTokenCsrf()
    {
        try {
            $value = true;
            if (empty($this->token) || $this->token != $_SESSION['csrf_token']) {
                $value = false;
            } else {
                $this->csrf_token_update();
            }
            return $value;
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    function csrf_token_update()
    {
        try {
            $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
        } catch (Exception $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }
}


/*
    // Eliminar el registro con ID 3 de la tabla "usuarios"
    $db->delete('usuarios', 3);
*/

//echo __NAMESPACE__;
?>