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
        if (empty($dta->cliente) && empty($dta->documento)) {
            return false;
        }
        return $this->model('ModelQuienDebe')->optenerDeudor($dta->cliente, $dta->documento);
    }

    public function postPagar($dta)
    {
        return $this->model('ModelQuienDebe')->pagar($dta);
    }
}

require_once 'Redirecionar.php';
echo redirec('ControllerQuienDebe');
?>