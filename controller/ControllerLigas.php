<?php
require_once 'Controller.php';

class ControllerLigas extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postVender($dta)
    {
        return $this->model('ModelLiga')->vender($dta);
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

echo redirec('ControllerLigas');
?>