<?php
require_once 'Controller.php';
use Controllers\Controller;

class ControllerQuienDebe extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postOptenerDeudor($dta)
    {
        return $this->model('ModelQuienDebe')->optenerDeudor($dta->nombre, $dta->documento);
    }
}

require_once 'Redirecionar.php';
echo redirec('ControllerQuienDebe');
?>