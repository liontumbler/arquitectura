<?php
require_once 'Controller.php';
use Controllers\Controller;

class ControllerLogin extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postLogin($dta)
    {
        //echo 'llegue';
        //print_r($dta);
        if ($dta->nickname != '' && $dta->nickname == 'cuadros@gim') {
            if ($dta->clave != '' && $dta->clave == '1234') {
                $_SESSION['SesionTrabajador'] = true;
                $_SESSION['Usuario'] = '1';
                $_SESSION['Nombre'] = 'cuadros';
                $_SESSION['gimnasio'] = 'cuadros';
                $_SESSION['ligas'] = '0';
                $_SESSION['tienda'] = '0';
                $_SESSION['pagos'] = '0';
                $_SESSION['descuento'] = '0';
                $_SESSION['caja'] = $dta->caja;
                return true;
            }
        }

        return false;
        //llamar metodo para iniciar session
    }

    public function postCerrarSession()
    {
        session_destroy();
        session_unset();

        return true;
    }

    
}

require_once 'Redirecionar.php';
echo redirec('ControllerLogin');
?>