<?php
require_once 'Controller.php';
use Controllers\Controller;

class ControllerTest extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postIndex()
    {
        $valido = $this->validarTokenCsrf();
        if ($valido) {
            return $this->model('ModelTest');
        } else {
            return $valido;
        }
    }

    public function postDatos()
    {
        $array = array(array('id' => '1', 'name' => 'pepe'), array('id' => '2', 'name' => 'pepi'));
        return $array;
    }

    public function postDatos2($data)
    {
        return $data;
    }

    public function sessionTrabajador()
    {
        @\session_start();

        $_SESSION['sesionTrabajador'] = true;
        $_SESSION['moduloLigas'] = true;
        $_SESSION['moduloTienda'] = true;
        //...
    }

    public function cerrarSession()
    {
        @\session_start();
        session_destroy();
        session_unset();

        //retornar a la raiz
    }
}

require_once 'Redirecionar.php';
echo redirec('ControllerTest');
?>