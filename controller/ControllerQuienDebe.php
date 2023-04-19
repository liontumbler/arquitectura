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
        echo 'llegue';
        print_r($dta->nombre);
    }

    
}

require_once 'Redirecionar.php';
echo redirec('ControllerQuienDebe');
?>