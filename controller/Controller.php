<?php
namespace Controllers;

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
        @\session_start();
        $this->token = $token;
    }
    protected function model($modelo)
    {
        $pMayuscula = ucfirst($modelo);
        $ruta = '../model/'. $pMayuscula .'.php';

        //return $ruta;
        if (is_file($ruta)) {
            //return true;
            require_once $ruta;
            return new $pMayuscula;
        } else {
            return false;
        }
    }

    protected function view($view)
    {
        $ruta = '../view/'. $view .'.php';
        if (is_file($ruta)) {
            require_once $ruta;
            return new $view;
        } else {
            return false;
        }
    }

    protected function validarTokenCsrf()
    {
        $value = true;
        if (!isset($this->token) || $this->token != $_SESSION['csrf_token']) {
            $value = false;
        }else {
            $this->csrf_token_update();
        }
        //echo $this->token;
        //echo '<br>';
        //print_r($_SESSION);
        return $value;
    }

    function csrf_token_update()
    {
        $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
    }
}

//echo __NAMESPACE__;
?>