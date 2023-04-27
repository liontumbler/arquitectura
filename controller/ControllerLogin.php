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
        return $this->model('ModelLogin')->login($dta->nickname, $dta->clave, $dta->caja);
    }

    public function postCerrarCaja($dta)
    {
        return $dta;
        //finSesion($plata)
    }
}

require_once 'Redirecionar.php';
echo redirec('ControllerLogin');
?>