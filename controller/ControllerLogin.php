<?php
require_once 'Controller.php';

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

echo redirec('ControllerLogin');
?>