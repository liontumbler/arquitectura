<?php
require_once 'Controller.php';

class ControllerHoraLiga extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postAgregarHoraLiga($dta)
    {
        return $this->model('ModelHoraLiga')->agregarHoraLiga($dta);
    }

    public function postCargarHoraLigas()
    {
        return $this->model('ModelHoraLiga')->cargarHoraLigas();
    }


    

    
}

echo redirec('ControllerHoraLiga');
?>