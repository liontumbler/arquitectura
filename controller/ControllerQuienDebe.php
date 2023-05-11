<?php
require_once 'Controller.php';

class ControllerQuienDebe extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postOptenerDeudor($dta)
    {
        return $this->model('ModelQuienDebe')->optenerDeudor($dta->cliente);
    }

    public function postPagar($dta)
    {
        return $this->model('ModelQuienDebe')->pagar($dta);
    }
}

echo redirec('ControllerQuienDebe');
?>