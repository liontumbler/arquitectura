<?php
require_once 'Controller.php';
use Controllers\Controller;

class ControllerTienda extends Controller
{
    function __construct($token)
    {
        parent::__construct($token);
    }

    public function postVender($dta)
    {
        print_r($dta);
    }

    
}

require_once 'Redirecionar.php';
echo redirec('ControllerTienda');
?>