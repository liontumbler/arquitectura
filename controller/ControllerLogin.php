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
        echo 'llegue';
        //print_r($dta);
        if ($dta->nickname != '' && $dta->nickname == 'cuadros@gim') {
            if ($dta->clave != '' && $dta->clave == '1234') {
                $_SESSION['SesionTrabajador'] = true;
                $_SESSION['Usuario'] = '1';
                $_SESSION['Nombre'] = 'cuadros';

                print_r($_SESSION);//csrf_token
            }
            

        }
        //llamar metodo para iniciar session
    }

    
}

require_once 'Redirecionar.php';
echo redirec('ControllerLogin');
?>