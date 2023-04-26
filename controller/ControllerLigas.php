<?php
require_once 'Controller.php';
use Controllers\Controller;

class ControllerLigas extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postVender($dta)
    {
        print_r($dta);
    }

    public function postCargarHoras()
    {
        return $this->model('ModelLiga')->horas();
    }

    public function postMinDemas()
    {
        return $this->model('ModelLiga')->minDemas();
    }

    public function postClaveCaja($dta)
    {
        return $this->model('ModelLiga')->claveCaja($dta->clave);
    }

    

    
}

require_once 'Redirecionar.php';
echo redirec('ControllerLigas');
?>